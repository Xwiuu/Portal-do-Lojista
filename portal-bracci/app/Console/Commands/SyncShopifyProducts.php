<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ShopifyService;

class SyncShopifyProducts extends Command
{
    // A assinatura tem que ser essa
    protected $signature = 'shopify:sync-products';
    protected $description = 'Sincroniza produtos da Shopify';

    public function handle()
    {
        $this->info('Iniciando comunicação com a Shopify...');

        $service = new ShopifyService();
        $products = $service->getAllProducts();

        $this->comment('Total de produtos encontrados: ' . count($products));

        foreach ($products as $product) {
            foreach ($product['variants'] as $variant) {
                $this->info("Sincronizando SKU: " . $variant['sku']);

                \App\Models\Product::updateOrCreate(
                    ['shopify_variant_id' => $variant['id']], // Use o ID da VARIANTE como chave única
                    [
                        'shopify_product_id' => $product['id'],
                        'title' => $product['title'] . ' - ' . $variant['title'], // Ex: Torneira Slim - Dourada
                        'sku' => $variant['sku'],
                        'price' => $variant['price'],
                        'inventory' => $variant['inventory_quantity'] ?? 0,
                        'image_url' => $product['image']['src'] ?? null,
                        'handle' => $product['handle']
                    ]
                );
            }
        }

        $this->info('Sincronização concluída!');
    }
}
