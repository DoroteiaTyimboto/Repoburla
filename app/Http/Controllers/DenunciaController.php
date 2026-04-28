<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Comentario;
use App\Models\Avaliacao;
use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DenunciaController extends Controller
{
    private function notifyUser(int $userId, string $tipo, string $titulo, string $mensagem, ?string $url = null): void
    {
        Notificacao::create([
            'user_id' => $userId,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensagem' => $mensagem,
            'url' => $url,
        ]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $denuncias = Denuncia::where('status', '!=', 'rejeitado')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('denuncias.index', ['denuncias' => $denuncias]);
    }

    public function create()
    {
        return view('denuncias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'tipo' => 'required|in:phishing,malware,fraude,roubo_identidade,spam,outro',
            'url_suspeita' => 'nullable|url',
            'evidencias' => 'nullable|array',
            'provas' => 'nullable|array',
            'provas.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,mp4,mov,webm,mp3,wav,m4a,ogg,aac|max:51200',
            'prioridade' => 'nullable|in:baixa,media,alta',
            'localizacao' => 'nullable|string|max:100',
            'data_incidente' => 'nullable|date|before_or_equal:today',
        ]);

        $evidencias = $validated['evidencias'] ?? [];

        if ($request->hasFile('provas')) {
            foreach ($request->file('provas') as $prova) {
                $path = $prova->store('denuncias/provas', 'public');
                $evidencias[] = [
                    'nome' => $prova->getClientOriginalName(),
                    'caminho' => $path,
                    'mime' => $prova->getClientMimeType(),
                    'tamanho' => $prova->getSize(),
                ];
            }
        }

        $denuncia = Denuncia::create([
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'tipo' => $validated['tipo'],
            'url_suspeita' => $validated['url_suspeita'] ?? null,
            'evidencias' => $evidencias,
            'prioridade' => $validated['prioridade'] ?? 'media',
            'localizacao' => $validated['localizacao'] ?? null,
            'data_incidente' => $validated['data_incidente'] ?? now()->toDateString(),
            'status' => 'pendente',
        ]);

        $moderadores = User::whereIn('role', ['admin', 'moderator'])->where('is_active', true)->pluck('id');
        foreach ($moderadores as $moderadorId) {
            $this->notifyUser(
                (int) $moderadorId,
                'denuncia',
                'Nova denúncia pendente',
                'Uma nova denúncia foi registrada e aguarda moderação.',
                route('denuncias.show', $denuncia)
            );
        }

        return redirect()->route('denuncias.show', $denuncia)->with('success', 'Denúncia registrada com sucesso!');
    }

    public function show(Denuncia $denuncia)
    {
        $comentarios = $denuncia->comentarios()->principal()->with('user')->paginate(10);
        $avaliacoes = $denuncia->avaliacoes()->get();
        $mediaAvaliacoes = $avaliacoes->avg('classificacao');

        return view('denuncias.show', [
            'denuncia' => $denuncia,
            'comentarios' => $comentarios,
            'avaliacoes' => $avaliacoes,
            'mediaAvaliacoes' => round($mediaAvaliacoes, 1),
        ]);
    }

    public function edit(Denuncia $denuncia)
    {
        if($denuncia->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        return view('denuncias.edit', ['denuncia' => $denuncia]);
    }

    public function update(Request $request, Denuncia $denuncia)
    {
        if($denuncia->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        if($denuncia->status !== 'pendente' && $denuncia->user_id !== Auth::id()) {
            return back()->with('error', 'Denúncia não pode ser editada neste status.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'tipo' => 'required|in:phishing,malware,fraude,roubo_identidade,spam,outro',
            'url_suspeita' => 'nullable|url',
            'provas' => 'nullable|array',
            'provas.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,mp4,mov,webm,mp3,wav,m4a,ogg,aac|max:51200',
            'prioridade' => 'nullable|in:baixa,media,alta',
            'localizacao' => 'nullable|string|max:100',
        ]);

        $evidencias = is_array($denuncia->evidencias) ? $denuncia->evidencias : [];

        if ($request->hasFile('provas')) {
            foreach ($request->file('provas') as $prova) {
                $path = $prova->store('denuncias/provas', 'public');
                $evidencias[] = [
                    'nome' => $prova->getClientOriginalName(),
                    'caminho' => $path,
                    'mime' => $prova->getClientMimeType(),
                    'tamanho' => $prova->getSize(),
                ];
            }
        }

        $validated['evidencias'] = $evidencias;

        $denuncia->update($validated);
        return redirect()->route('denuncias.show', $denuncia)->with('success', 'Denúncia atualizada com sucesso!');
    }

    public function approve(Denuncia $denuncia)
    {
        if(!Auth::user()->isModerator()) {
            abort(403);
        }

        $denuncia->markAsApproved([
            'verificado_por' => Auth::user()->name,
            'data_verificacao' => now(),
        ]);

        $this->notifyUser(
            $denuncia->user_id,
            'denuncia',
            'Denúncia aprovada',
            'Sua denúncia "'.$denuncia->titulo.'" foi aprovada.',
            route('denuncias.show', $denuncia)
        );

        return back()->with('success', 'Denúncia aprovada!');
    }

    public function resolve(Denuncia $denuncia)
    {
        if(!Auth::user()->isModerator()) {
            abort(403);
        }

        $denuncia->markAsResolved();

        $this->notifyUser(
            $denuncia->user_id,
            'denuncia',
            'Denúncia resolvida',
            'Sua denúncia "'.$denuncia->titulo.'" foi marcada como resolvida.',
            route('denuncias.show', $denuncia)
        );
        return back()->with('success', 'Denúncia marcada como resolvida!');
    }

    public function reject(Request $request, Denuncia $denuncia)
    {
        if(!Auth::user()->isModerator()) {
            abort(403);
        }

        $validated = $request->validate([
            'motivo' => 'required|string|min:10',
        ]);

        $denuncia->update([
            'status' => 'rejeitado',
            'resultado_verificacao' => [
                'motivo_rejeicao' => $validated['motivo'],
                'rejeitado_por' => Auth::user()->name,
                'data_rejeicao' => now(),
            ],
        ]);

        $this->notifyUser(
            $denuncia->user_id,
            'denuncia',
            'Denúncia rejeitada',
            'Sua denúncia "'.$denuncia->titulo.'" foi rejeitada. Verifique o motivo informado.',
            route('denuncias.show', $denuncia)
        );

        return back()->with('success', 'Denúncia rejeitada!');
    }

    public function reportToAuthorities(Denuncia $denuncia)
    {
        $user = Auth::user();
        $canReport = $user->isModerator() || $denuncia->user_id === $user->id;

        if(!$canReport) {
            abort(403);
        }

        if($denuncia->status !== 'aprovado') {
            return back()->with('error', 'A denúncia precisa estar aprovada para ser reportada às autoridades.');
        }

        $resultadoVerificacao = is_array($denuncia->resultado_verificacao)
            ? $denuncia->resultado_verificacao
            : [];

        if(($resultadoVerificacao['reportado_autoridades'] ?? null) === 'Sim') {
            return back()->with('error', 'Esta denúncia já foi reportada às autoridades.');
        }

        $resultadoVerificacao['reportado_autoridades'] = 'Sim';
        $resultadoVerificacao['autoridade_destino'] = 'Autoridades competentes';
        $resultadoVerificacao['reportado_por'] = $user->name;
        $resultadoVerificacao['data_reporte_autoridade'] = now()->format('d/m/Y H:i');

        $denuncia->update([
            'resultado_verificacao' => $resultadoVerificacao,
        ]);

        $this->notifyUser(
            $denuncia->user_id,
            'denuncia',
            'Denúncia reportada às autoridades',
            'Sua denúncia "'.$denuncia->titulo.'" foi reportada às autoridades.',
            route('denuncias.show', $denuncia)
        );

        return back()->with('success', 'Denúncia reportada às autoridades com sucesso!');
    }

    public function destroy(Denuncia $denuncia)
    {
        if(!Auth::user()->isAdmin()) {
            abort(403);
        }

        if (is_array($denuncia->evidencias)) {
            foreach ($denuncia->evidencias as $evidencia) {
                if (is_array($evidencia) && !empty($evidencia['caminho'])) {
                    Storage::disk('public')->delete($evidencia['caminho']);
                }
            }
        }

        $denuncia->delete();
        return redirect()->route('denuncias.index')->with('success', 'Denúncia eliminada com sucesso!');
    }

    public function addComment(Request $request, Denuncia $denuncia)
    {
        $validated = $request->validate([
            'conteudo' => 'required|string|min:5',
        ]);

        Comentario::create([
            'user_id' => Auth::id(),
            'denuncia_id' => $denuncia->id,
            'conteudo' => $validated['conteudo'],
        ]);

        if (Auth::id() !== $denuncia->user_id) {
            $this->notifyUser(
                $denuncia->user_id,
                'comentario',
                'Novo comentário na sua denúncia',
                Auth::user()->name.' comentou na denúncia "'.$denuncia->titulo.'".',
                route('denuncias.show', $denuncia)
            );
        }

        return back()->with('success', 'Comentário adicionado!');
    }

    public function rate(Request $request, Denuncia $denuncia)
    {
        $validated = $request->validate([
            'classificacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|min:5',
        ]);

        Avaliacao::updateOrCreate(
            ['user_id' => Auth::id(), 'denuncia_id' => $denuncia->id],
            [
                'classificacao' => $validated['classificacao'],
                'comentario' => $validated['comentario'] ?? null,
                'tipo_recurso' => 'denuncia',
            ]
        );

        return back()->with('success', 'Classificação registrada!');
    }

    public function myReports()
    {
        $denuncias = Auth::user()->denuncias()->orderBy('created_at', 'desc')->paginate(15);
        return view('denuncias.my-reports', ['denuncias' => $denuncias]);
    }
}
