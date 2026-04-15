<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Denuncia;
use App\Models\Curso;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Estatísticas do usuário
        $minhasDenuncias = $user->denuncias()->count();
        $meusRelatorios = [
            'total' => $minhasDenuncias,
            'pendente' => $user->denuncias()->pendente()->count(),
            'aprovado' => $user->denuncias()->aprovado()->count(),
            'resolvido' => $user->denuncias()->resolvido()->count(),
        ];

        $cursosDados = [
            'total' => $user->cursosInscritos()->count(),
            'concluido' => $user->cursosInscritos()->wherePivot('concluido_em', '!=', null)->count(),
            'emProgresso' => $user->cursosInscritos()->wherePivot('concluido_em', null)->count(),
        ];

        $notificacoes = $user->notificacoes()->naoLidas()->limit(5)->get();

        // Sistema stats
        if($user->isModerator()) {
            $sistemaDados = [
                'totalDenuncias' => Denuncia::count(),
                'denunciasPendentes' => Denuncia::pendente()->count(),
                'denunciasAlta' => Denuncia::alta()->count(),
                'totalUsuarios' => \App\Models\User::count(),
                'cursosPublicados' => Curso::published()->count(),
            ];
        } else {
            $sistemaDados = null;
        }

        return view('dashboard', [
            'user' => $user,
            'meusRelatorios' => $meusRelatorios,
            'cursosDados' => $cursosDados,
            'notificacoes' => $notificacoes,
            'sistemaDados' => $sistemaDados,
        ]);
    }
}
