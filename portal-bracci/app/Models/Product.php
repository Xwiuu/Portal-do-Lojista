<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Essa linha mágica desliga o bloqueio de segurança e deixa salvar todos os campos
    protected $guarded = []; 
}