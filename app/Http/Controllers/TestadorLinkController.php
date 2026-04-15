<?php

namespace App\Http\Controllers;

use App\Models\TestadorLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\TransferStats;

class TestadorLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $historico = Auth::user()->testadorLinks()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $estatisticas = [
            'total' => Auth::user()->testadorLinks()->count(),
            'seguro' => Auth::user()->testadorLinks()->where('classificacao_risco', 'seguro')->count(),
            'suspeito' => Auth::user()->testadorLinks()->where('classificacao_risco', 'suspeito')->count(),
            'perigoso' => Auth::user()->testadorLinks()->where('classificacao_risco', 'perigoso')->count(),
        ];

        return view('testador.index', [
            'historico' => $historico,
            'estatisticas' => $estatisticas,
        ]);
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
        ]);

        $url = $validated['url'];

        // Verificar se já existe teste recente
        $recenteTest = TestadorLink::where('url_testada', $url)
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subHours(1))
            ->first();

        if($recenteTest) {
            return response()->json($recenteTest);
        }

        $resultado = $this->verificarUrl($url);

        $testador = TestadorLink::create([
            'user_id' => Auth::id(),
            'url_testada' => $url,
            'resultado' => $resultado['resultado'],
            'classificacao_risco' => $resultado['risco'],
            'detalhes_verificacao' => $resultado['detalhes'],
            'tempo_verificacao' => $resultado['tempo'],
            'ip_destino' => $resultado['ip'] ?? null,
            'certificado_ssl' => $resultado['ssl'] ?? null,
            'reputacao_dominio' => $resultado['reputacao'] ?? null,
        ]);

        return response()->json($testador);
    }

    public function show(TestadorLink $testador)
    {
        if($testador->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        return view('testador.show', ['testador' => $testador]);
    }

    private function verificarUrl($url): array
    {
        $inicio = microtime(true);
        $redirectsDetectados = false;

        try {
            $client = new Client([
                'timeout' => 5,
                'verify' => false,
            ]);

            try {
                $response = $client->request('HEAD', $url, [
                    'allow_redirects' => [
                        'track_redirects' => true,
                    ],
                    'http_errors' => true,
                    'on_stats' => function (TransferStats $stats) use (&$redirectsDetectados) {
                        $effectiveUri = (string) $stats->getEffectiveUri();
                        $redirectsDetectados = $effectiveUri !== '' && $effectiveUri !== $stats->getRequest()->getUri()->__toString();
                    },
                ]);
            } catch (RequestException $e) {
                $status = $e->getResponse()?->getStatusCode();

                if(in_array($status, [0, 403, 405, 429, 500, 501, 502, 503], true)) {
                    $response = $client->request('GET', $url, [
                        'allow_redirects' => [
                            'track_redirects' => true,
                        ],
                        'http_errors' => false,
                        'stream' => true,
                        'on_stats' => function (TransferStats $stats) use (&$redirectsDetectados) {
                            $effectiveUri = (string) $stats->getEffectiveUri();
                            $redirectsDetectados = $effectiveUri !== '' && $effectiveUri !== $stats->getRequest()->getUri()->__toString();
                        },
                    ]);
                } else {
                    throw $e;
                }
            }

            $statusCode = $response->getStatusCode();
            $headers = $response->getHeaders();

            // Verificar SSL
            $sslInfo = $this->verificarSSL($url);

            // Verificar padrões suspeitos na URL
            $risco = $this->classificarRisco($url, $statusCode, $sslInfo, $redirectsDetectados);

            $tempo = round((microtime(true) - $inicio) * 1000);

            return [
                'resultado' => [
                    'status_code' => $statusCode,
                    'status_texto' => 'Conectado com sucesso',
                ],
                'risco' => $risco,
                'detalhes' => [
                    'content_type' => $headers['Content-Type'][0] ?? 'unknown',
                    'server' => $headers['Server'][0] ?? 'unknown',
                    'redirects_detectados' => $redirectsDetectados,
                ],
                'tempo' => $tempo,
                'ip' => gethostbyname(parse_url($url, PHP_URL_HOST)),
                'ssl' => $sslInfo,
                'reputacao' => $this->verificarReputacao($url),
            ];
        } catch (RequestException $e) {
            $tempo = round((microtime(true) - $inicio) * 1000);

            return [
                'resultado' => [
                    'status_code' => $e->getResponse()?->getStatusCode() ?? 0,
                    'status_texto' => $e->getMessage(),
                ],
                'risco' => 'suspeito',
                'detalhes' => [
                    'erro' => $e->getMessage(),
                ],
                'tempo' => $tempo,
                'ip' => null,
                'ssl' => null,
                'reputacao' => 'desconhecido',
            ];
        } catch (\Exception $e) {
            $tempo = round((microtime(true) - $inicio) * 1000);

            return [
                'resultado' => [
                    'status_code' => 0,
                    'status_texto' => 'Erro na verificação',
                ],
                'risco' => 'perigoso',
                'detalhes' => [
                    'erro' => $e->getMessage(),
                ],
                'tempo' => $tempo,
                'ip' => null,
                'ssl' => null,
                'reputacao' => 'perigoso',
            ];
        }
    }

    private function verificarSSL($url): ?array
    {
        try {
            if(parse_url($url, PHP_URL_SCHEME) !== 'https') {
                return null;
            }

            $host = parse_url($url, PHP_URL_HOST);
            $streamContext = stream_context_create([
                'ssl' => [
                    'capture_peer_cert' => true,
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                ]
            ]);

            $handle = fopen("ssl://{$host}:443", 'r', false, $streamContext);
            if(!$handle) {
                return null;
            }

            $params = stream_context_get_params($handle);
            fclose($handle);

            if(!isset($params['options']['ssl']['peer_certificate'])) {
                return null;
            }

            $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
            $validFrom = $cert['validFrom_time_t'] ?? null;
            $validTo = $cert['validTo_time_t'] ?? null;

            if($validFrom === null || $validTo === null) {
                return null;
            }

            return [
                'valido' => $validFrom <= time() && $validTo >= time(),
                'valido_ate' => date('Y-m-d', $validTo),
                'emitido_por' => $cert['issuer']['O'] ?? 'Unknown',
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function classificarRisco($url, $statusCode, $sslInfo, bool $redirectsDetectados): string
    {
        $risco = 'seguro';
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        // Verificar padrões suspeitos na URL
        if(preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $url)) {
            $risco = 'suspeito';
        }

        if(str_contains($host, '--') || str_contains($host, 'xn--')) {
            $risco = 'suspeito';
        }

        // Verificar palavras suspeitas no host
        $palavras_suspeitas = ['login', 'account', 'verify', 'update', 'confirm', 'secure', 'bank'];
        foreach($palavras_suspeitas as $palavra) {
            if(stripos($host, $palavra) !== false) {
                $risco = 'suspeito';
            }
        }

        if($scheme === 'http') {
            $risco = 'suspeito';
        }

        if($scheme === 'https' && ($sslInfo === null || !$sslInfo['valido'])) {
            $risco = 'suspeito';
        }

        if($statusCode >= 404) {
            $risco = 'suspeito';
        }

        if($redirectsDetectados && $scheme === 'http') {
            $risco = 'suspeito';
        }

        return $risco;
    }

    private function verificarReputacao($url): string
    {
        // Implementar lógica de verificação de reputação
        // Por enquanto retorna 'desconhecido'
        return 'desconhecido';
    }

    public function delete(TestadorLink $testador)
    {
        if($testador->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        $testador->delete();
        return back()->with('success', 'Teste deletado com sucesso!');
    }
}
