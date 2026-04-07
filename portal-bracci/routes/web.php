<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::get('/auth/callback', function (Request $request) {
    $shop = $request->query('shop');
    $code = $request->query('code');

    if (!$shop || !$code) return "Faltam parâmetros!";

    // Trocando o 'code' pelo Access Token real
    $response = Http::withoutVerifying()->post("https://{$shop}/admin/oauth/access_token", [
        'client_id'     => env('SHOPIFY_API_KEY'),
        'client_secret' => env('SHOPIFY_API_SECRET'), // Use a 'Chave Secreta' do painel aqui
        'code'          => $code,
    ]);

    return $response->json();
});