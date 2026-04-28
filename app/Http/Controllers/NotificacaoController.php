<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notificacoes = Auth::user()
            ->notificacoes()
            ->paginate(20);

        return view('notificacoes.index', [
            'notificacoes' => $notificacoes,
        ]);
    }

    public function summary(): JsonResponse
    {
        $user = Auth::user();
        $items = $user->notificacoes()->limit(6)->get();

        return response()->json([
            'unread_count' => $user->notificacoes()->naoLidas()->count(),
            'items' => $items->map(function (Notificacao $item) {
                return [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'mensagem' => $item->mensagem,
                    'url' => $item->url,
                    'is_read' => $item->é_lida,
                    'created_at' => $item->created_at?->format('d/m/Y H:i'),
                ];
            })->values(),
        ]);
    }

    public function markAsRead(Request $request, Notificacao $notificacao)
    {
        if ($notificacao->user_id !== Auth::id()) {
            abort(403);
        }

        $notificacao->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        $redirect = $request->input('redirect');

        if (!empty($redirect)) {
            return redirect($redirect);
        }

        return back()->with('success', 'Notificação marcada como lida.');
    }

    public function markAllAsRead(Request $request)
    {
        Auth::user()
            ->notificacoes()
            ->naoLidas()
            ->update(['é_lida' => true]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }
}

