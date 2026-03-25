<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id',
        'sku_produto',
        'quantidade',
        'preco_unitario_aplicado',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
