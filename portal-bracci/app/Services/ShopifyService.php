<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyService
{
    protected $baseUrl;
    protected $accessToken;
    protected $apiVersion;

    public function __construct()
    {
        // Puxa as credenciais do .env de forma segura
        $this->baseUrl = 'https://' . env('SHOPIFY_STORE_URL');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');
        $this->apiVersion = env('SHOPIFY_API_VERSION', '2026-01');
    }

    /**
     * Busca os produtos ativos na Shopify
     */
    public function getAllProducts()
    {
        $allProducts = [];
        // Começamos com o limite máximo de 250 por página
        $url = "https://" . env('SHOPIFY_STORE_URL') . "/admin/api/" . env('SHOPIFY_API_VERSION') . "/products.json?limit=250";

        while ($url) {
            $response = Http::withoutVerifying()
                ->withHeaders(['X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')])
                ->get($url);

            if ($response->successful()) {
                $allProducts = array_merge($allProducts, $response->json()['products']);
                
                // Verifica se tem uma "próxima página" no header de Link
                $linkHeader = $response->header('Link');
                $url = null; // Reset para parar o loop se não houver próxima

                if ($linkHeader && str_contains($linkHeader, 'rel="next"')) {
                    preg_match('/<([^>]+)>;\s*rel="next"/', $linkHeader, $matches);
                    $url = $matches[1] ?? null;
                }
            } else {
                $url = null; // Para o loop em caso de erro
            }
        }

        return $allProducts;
    }
}
