<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Multi-tenancy
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            
            // Relationship to Category (if a category is deleted, set this to null so we don't lose the product)
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name');
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->text('description')->nullable();
            
            // Use decimal for money! (10 digits total, 2 after the decimal point)
            $table->decimal('cost_price', 10, 2); 
            $table->decimal('price', 10, 2);      
            
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};