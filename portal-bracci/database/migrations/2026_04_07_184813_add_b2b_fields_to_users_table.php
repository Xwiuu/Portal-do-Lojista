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
    Schema::table('users', function (Blueprint $table) {
        // Remova o 'status' (e o 'role' se precisar) se eles já existirem na tabela base.
        
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('lojista');
        }
        
        if (!Schema::hasColumn('users', 'document_type')) {
            $table->string('document_type')->nullable(); 
        }
        
        if (!Schema::hasColumn('users', 'document_number')) {
            $table->string('document_number')->unique()->nullable(); 
        }
        
        if (!Schema::hasColumn('users', 'professional_registry')) {
            $table->string('professional_registry')->nullable(); 
        }
        
        if (!Schema::hasColumn('users', 'discount_percent')) {
            $table->decimal('discount_percent', 5, 2)->default(0); 
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'role', 
            'status', 
            'document_type', 
            'document_number', 
            'professional_registry', 
            'discount_percent'
        ]);
    });
}
};
