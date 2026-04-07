<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

// 1️⃣ PORTA DOS FUNDOS (VIP)
Route::get('/entrar-vip', function () {
    $admin = User::where('email', 'admin@bracci.com.br')->first();
    Auth::login($admin);
    return "Aí sim! Logado como Admin. Agora abra: /produtos";
});

// 2️⃣ O COFRE DE PRODUTOS (Protegido)
Route::middleware(['auth', 'b2b.approved'])->group(function () {
    
    Route::get('/produtos', function () {
        return Product::all(); 
    });

});