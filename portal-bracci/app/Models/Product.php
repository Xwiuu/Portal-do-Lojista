<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'nome',
        'imagem_url',
        'preco_base',
        'ativo',
    ];
}