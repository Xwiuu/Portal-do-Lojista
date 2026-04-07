<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckB2BApproval
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // 1. Se não estiver logado, chuta pra fora (Retorna erro 401 de API)
        if (!$user) {
            return response()->json(['error' => 'Acesso negado. Faça login.'], 401);
        }

        // 2. Se for Admin da Bracci, passa direto (Tapete Vermelho)
        if ($user->role === 'admin') {
            return $next($request);
        }

        // 3. Se for Lojista/Arquiteto, verifica se a IA/Comercial já aprovou
        if ($user->status === 'aprovado') {
            return $next($request);
        }

        // 4. Se chegou aqui, é porque tá 'pendente' ou 'rejeitado'
        return response()->json([
            'error' => 'Conta em análise.',
            'message' => 'Sua conta está sendo avaliada pelo nosso time comercial.'
        ], 403);
    }
}