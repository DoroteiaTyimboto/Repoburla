<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Comentario;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::published()->orderBy('ordem')->paginate(12);
        $categorias = Curso::published()->distinct()->pluck('categoria');

        return view('cursos.index', [
            'cursos' => $cursos,
            'categorias' => $categorias,
        ]);
    }

    public function filter(Request $request)
    {
        $query = Curso::published();

        if($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if($request->filled('nivel')) {
            $query->where('nivel', $request->nivel);
        }

        if($request->filled('busca')) {
            $query->where('titulo', 'like', '%'.$request->busca.'%')
                  ->orWhere('descricao', 'like', '%'.$request->busca.'%');
        }

        $cursos = $query->orderBy('ordem')->paginate(12);

        return view('cursos.index', [
            'cursos' => $cursos,
            'categorias' => Curso::published()->distinct()->pluck('categoria'),
        ]);
    }

    public function show(Curso $curso)
    {
        if(!$curso->is_published && (!Auth::check() || !Auth::user()->isModerator())) {
            abort(404);
        }

        $isInscrito = Auth::check() ? Auth::user()->cursosInscritos->contains($curso) : false;
        $comentarios = $curso->comentarios()->principal()->with('user')->paginate(10);
        $avaliacoes = $curso->avaliacoes()->get();
        $mediaAvaliacoes = $avaliacoes->avg('classificacao');

        return view('cursos.show', [
            'curso' => $curso,
            'isInscrito' => $isInscrito,
            'comentarios' => $comentarios,
            'avaliacoes' => $avaliacoes,
            'mediaAvaliacoes' => round($mediaAvaliacoes, 1),
            'totalInscritos' => $curso->getTotalInscritos(),
            'totalConcluido' => $curso->getTotalConcluido(),
            'taxaConclusao' => $curso->getTaxaConclusao(),
        ]);
    }

    public function enroll(Curso $curso)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if($user->cursosInscritos->contains($curso)) {
            return back()->with('info', 'Você já está inscrito neste curso.');
        }

        $user->cursosInscritos()->attach($curso->id, [
            'progresso' => 0,
        ]);

        return back()->with('success', 'Inscrito com sucesso no curso!');
    }

    public function unenroll(Curso $curso)
    {
        Auth::user()->cursosInscritos()->detach($curso->id);
        return back()->with('success', 'Desinscrição realizada com sucesso!');
    }

    public function updateProgress(Request $request, Curso $curso)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'progresso' => 'required|integer|min:0|max:100',
        ]);

        Auth::user()->cursosInscritos()->updateExistingPivot($curso->id, [
            'progresso' => $validated['progresso'],
            'concluido_em' => $validated['progresso'] === 100 ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }

    public function addComment(Request $request, Curso $curso)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'conteudo' => 'required|string|min:5',
        ]);

        Comentario::create([
            'user_id' => Auth::id(),
            'curso_id' => $curso->id,
            'conteudo' => $validated['conteudo'],
        ]);

        return back()->with('success', 'Comentário adicionado!');
    }

    public function rate(Request $request, Curso $curso)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'classificacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|min:5',
        ]);

        Avaliacao::updateOrCreate(
            ['user_id' => Auth::id(), 'curso_id' => $curso->id],
            [
                'classificacao' => $validated['classificacao'],
                'comentario' => $validated['comentario'] ?? null,
                'tipo_recurso' => 'curso',
            ]
        );

        return back()->with('success', 'Classificação registrada!');
    }

    public function myCourses()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $cursos = Auth::user()->cursosInscritos()->paginate(12);
        return view('cursos.my-courses', ['cursos' => $cursos]);
    }

    // Admin methods
    public function admin()
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        $cursos = Curso::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.cursos.index', ['cursos' => $cursos]);
    }

    public function adminCreate()
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        return view('admin.cursos.create');
    }

    public function adminStore(Request $request)
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'conteudo' => 'nullable|string',
            'nivel' => 'required|in:iniciante,intermediario,avancado',
            'duracao_minutos' => 'nullable|integer|min:1',
            'categoria' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'is_published' => 'nullable|boolean',
            'ordem' => 'nullable|integer',
        ]);

        Curso::create([
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'conteudo' => $validated['conteudo'] ?? null,
            'nivel' => $validated['nivel'],
            'duracao_minutos' => $validated['duracao_minutos'] ?? 0,
            'categoria' => $validated['categoria'] ?? null,
            'tags' => $validated['tags'] ?? [],
            'is_published' => $validated['is_published'] ?? false,
            'ordem' => $validated['ordem'] ?? 0,
        ]);

        return redirect()->route('admin.cursos')->with('success', 'Curso criado com sucesso!');
    }

    public function adminEdit(Curso $curso)
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        return view('admin.cursos.edit', ['curso' => $curso]);
    }

    public function adminUpdate(Request $request, Curso $curso)
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'conteudo' => 'nullable|string',
            'nivel' => 'required|in:iniciante,intermediario,avancado',
            'duracao_minutos' => 'nullable|integer|min:1',
            'categoria' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'is_published' => 'nullable|boolean',
            'ordem' => 'nullable|integer',
        ]);

        $curso->update($validated);
        return redirect()->route('admin.cursos')->with('success', 'Curso atualizado com sucesso!');
    }

    public function adminDestroy(Curso $curso)
    {
        if(!Auth::user()?->isModerator()) {
            abort(403);
        }

        $curso->delete();
        return redirect()->route('admin.cursos')->with('success', 'Curso deletado com sucesso!');
    }
}
