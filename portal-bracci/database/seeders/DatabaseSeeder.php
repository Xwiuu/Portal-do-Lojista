<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criando o Lojista de Teste (Para você fazer login no MVP)
        User::create([
            'name' => 'Loja Parceira Bracci',
            'email' => 'lojista@teste.com',
            'password' => Hash::make('password'), // A senha será 'password'
            'cnpj' => '12.345.678/0001-90',
            'razao_social' => 'Boutique dos Pisos e Metais LTDA',
            'status' => 'ativo',
        ]);

        // 2. Criando o Catálogo Falso (Até a API do ViaSoft chegar amanhã)
        $produtos = [
            ['sku' => 'BR-1001', 'nome' => 'Misturador Monocomando Gold', 'preco' => 1250.00],
            ['sku' => 'BR-1002', 'nome' => 'Torneira Gourmet Black Matte', 'preco' => 890.50],
            ['sku' => 'BR-1003', 'nome' => 'Cuba de Apoio Branca', 'preco' => 450.00],
            ['sku' => 'BR-1004', 'nome' => 'Válvula Click Inox', 'preco' => 85.00],
            ['sku' => 'BR-1005', 'nome' => 'Ducha Higiênica Rose Gold', 'preco' => 320.00],
        ];

        foreach ($produtos as $produto) {
            Product::create([
                'sku' => $produto['sku'],
                'nome' => $produto['nome'],
                'preco_base' => $produto['preco'],
                'imagem_url' => 'https://via.placeholder.com/300x300.png?text=Bracci+Produto',
                'ativo' => true,
            ]);
        }
    }
}