<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql';
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('material_id'); // ID товара из SQL Server
            $table->string('material_code')->nullable();
            $table->string('material_name');
            $table->decimal('quantity', 18, 3);
            $table->decimal('price', 18, 2);
            $table->decimal('total', 18, 2);
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('order_items');
    }
};
