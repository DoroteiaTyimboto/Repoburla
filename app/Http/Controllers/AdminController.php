<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Denuncia;
use App\Models\Curso;
use App\Models\Quiz;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if(!Auth::user()->isModerator()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'totalUsuarios' => User::count(),
            'usuariosAtivos' => User::where('is_active', true)->count(),
            'totalDenuncias' => Denuncia::count(),
            'denunciasPendentes' => Denuncia::pendente()->count(),
            'totalCursos' => Curso::count(),
            'cursosPublicados' => Curso::published()->count(),
            'totalQuizzes' => Quiz::count(),
            'quizzesPublicados' => Quiz::published()->count(),
        ];

        $denunciasPendentes = Denuncia::pendente()->orderBy('prioridade')->limit(10)->get();
        $usuariosRecentes = User::orderBy('created_at', 'desc')->limit(10)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'denunciasPendentes' => $denunciasPendentes,
            'usuariosRecentes' => $usuariosRecentes,
        ]);
    }

    public function denuncias()
    {
        $denuncias = Denuncia::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.denuncias.index', ['denuncias' => $denuncias]);
    }

    public function denunciaFilter(Request $request)
    {
        $query = Denuncia::query();

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        if($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if($request->filled('busca')) {
            $query->where('titulo', 'like', '%'.$request->busca.'%')
                  ->orWhere('descricao', 'like', '%'.$request->busca.'%');
        }

        $denuncias = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.denuncias.index', ['denuncias' => $denuncias]);
    }

    public function usuarios()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.usuarios.index', ['usuarios' => $usuarios]);
    }

    public function usuarioEdit(User $user)
    {
        return view('admin.usuarios.edit', ['user' => $user]);
    }

    public function usuarioUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:user,moderator,admin',
            'is_active' => 'nullable|boolean',
        ]);

        $user->update($validated);
        return redirect()->route('admin.usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function usuarioDelete(User $user)
    {
        if($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode deletar sua própria conta!');
        }

        $user->delete();
        return back()->with('success', 'Usuário deletado com sucesso!');
    }

    public function relatorios()
    {
        $relatorios = [
            'denunciasPorTipo' => Denuncia::select('tipo')->get()->groupBy('tipo')->map->count(),
            'denunciasPorStatus' => Denuncia::select('status')->get()->groupBy('status')->map->count(),
            'cursosPopulares' => Curso::withCount('usuarios')->orderByDesc('usuarios_count')->limit(5)->get(),
            'usuariosAtivos' => User::where('is_active', true)->count(),
        ];

        return view('admin.relatorios', ['relatorios' => $relatorios]);
    }

    public function notificacoes()
    {
        $notificacoes = Notificacao::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notificacoes.index', ['notificacoes' => $notificacoes]);
    }

    public function enviarNotificacao(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:denuncia,curso,quiz,comentario,sistema',
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'para_usuario_id' => 'nullable|exists:users,id',
            'para_todos' => 'nullable|boolean',
        ]);

        if($validated['para_todos']) {
            $usuarios = User::where('is_active', true)->get();
            foreach($usuarios as $user) {
                Notificacao::create([
                    'user_id' => $user->id,
                    'tipo' => $validated['tipo'],
                    'titulo' => $validated['titulo'],
                    'mensagem' => $validated['mensagem'],
                    'url' => $request->url ?? null,
                ]);
            }
            return back()->with('success', 'Notificação enviada para todos os usuários!');
        } else {
            Notificacao::create([
                'user_id' => $validated['para_usuario_id'],
                'tipo' => $validated['tipo'],
                'titulo' => $validated['titulo'],
                'mensagem' => $validated['mensagem'],
                'url' => $request->url ?? null,
            ]);
            return back()->with('success', 'Notificação enviada com sucesso!');
        }
    }

    public function configuracoes()
    {
        return view('admin.configuracoes');
    }
}
