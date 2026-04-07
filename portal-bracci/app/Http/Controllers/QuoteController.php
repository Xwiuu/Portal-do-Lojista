<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    // Recebe o carrinho do Vue e salva no banco
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.sku' => 'required|string',
            'items.*.quantidade' => 'required|integer|min:1',
            'items.*.preco' => 'required|numeric',
            'valor_total' => 'required|numeric',
        ]);

        // Usamos transação para garantir que não salva orçamento pela metade se der erro
        DB::beginTransaction();

        try {
            // 1. Cria o Orçamento base
            $quote = Quote::create([
                'user_id' => Auth::id(), // Pega o ID do lojista logado
                'status' => 'enviado_para_analise',
                'valor_total' => $request->valor_total,
                'observacoes' => $request->observacoes ?? '',
            ]);

            // 2. Salva os itens do carrinho amarrados a esse orçamento
            foreach ($request->items as $item) {
                QuoteItem::create([
                    'quote_id' => $quote->id,
                    'sku_produto' => $item['sku'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario_aplicado' => $item['preco'],
                ]);
            }

            DB::commit();

            // Aqui no futuro vai o código que gera o PDF e avisa a Morgana/Moskit!

            return redirect()->back()->with('success', 'Orçamento gerado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Erro ao gerar orçamento: ' . $e->getMessage());
        }
    }
}