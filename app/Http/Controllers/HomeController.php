<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Curso;
use App\Models\TestadorLink;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Dados gerais para homepage
        $stats = [
            'totalDenuncias' => Denuncia::where('status', '!=', 'rejeitado')->count(),
            'denunciasResolvidas' => Denuncia::resolvido()->count(),
            'cursosDisponivel' => Curso::published()->count(),
            'linksTestados' => TestadorLink::count(),
        ];

        // Cursos em destaque
        $cursosDestaque = Curso::published()->orderBy('ordem')->limit(6)->get();

        // Últimas denúncias aprovadas
        $ultimasDenuncias = Denuncia::aprovado()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', [
            'stats' => $stats,
            'cursosDestaque' => $cursosDestaque,
            'ultimasDenuncias' => $ultimasDenuncias,
            'user' => Auth::user(),
        ]);
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function contato()
    {
        return view('contato');
    }

    public function mapa()
    {
        $denuncias = Denuncia::where('localizacao', '!=', null)
            ->where('status', '!=', 'rejeitado')
            ->get();

        return view('mapa', ['denuncias' => $denuncias]);
    }
}
