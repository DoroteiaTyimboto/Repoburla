<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Comentario;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DenunciaController extends Controller
{
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
            'prioridade' => 'nullable|in:baixa,media,alta',
            'localizacao' => 'nullable|string|max:100',
            'data_incidente' => 'nullable|date|before_or_equal:today',
        ]);

        $denuncia = Denuncia::create([
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'tipo' => $validated['tipo'],
            'url_suspeita' => $validated['url_suspeita'] ?? null,
            'evidencias' => $validated['evidencias'] ?? [],
            'prioridade' => $validated['prioridade'] ?? 'media',
            'localizacao' => $validated['localizacao'] ?? null,
            'data_incidente' => $validated['data_incidente'] ?? now()->date(),
            'status' => 'pendente',
        ]);

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
            'prioridade' => 'nullable|in:baixa,media,alta',
            'localizacao' => 'nullable|string|max:100',
        ]);

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

        return back()->with('success', 'Denúncia aprovada!');
    }

    public function resolve(Denuncia $denuncia)
    {
        if(!Auth::user()->isModerator()) {
            abort(403);
        }

        $denuncia->markAsResolved();
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

        return back()->with('success', 'Denúncia rejeitada!');
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
