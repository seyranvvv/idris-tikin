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
        Schema::connection('pgsql')->table('orders', function (Blueprint $table) {
            $table->string('delivery_type')->default('delivery'); // delivery (доставка)
            $table->string('payment_method')->default('cash'); // cash (наличные)
            $table->decimal('delivery_cost', 18, 2)->default(0);
            
            // Удаляем поле discount
            $table->dropColumn('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'payment_method', 'delivery_cost']);
            $table->decimal('discount', 18, 2)->default(0);
        });
    }
};
