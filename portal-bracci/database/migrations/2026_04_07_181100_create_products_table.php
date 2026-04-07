<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('shopify_product_id')->index(); // ID do produto pai
        $table->string('shopify_variant_id')->unique(); // ID da variante (SKU único)
        $table->string('title'); // Nome (Ex: Torneira Slim - Dourada)
        $table->string('sku')->nullable()->index(); // O código de vocês
        $table->decimal('price', 10, 2)->default(0); // Preço que vem da Shopify
        $table->integer('inventory')->default(0); // Estoque da Shopify
        $table->string('image_url')->nullable(); // O link da foto
        $table->string('handle')->nullable(); // URL amigável
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
