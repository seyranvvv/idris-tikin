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
        Schema::connection('pgsql')->create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // WEB-20251110-1234
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address')->nullable();
            $table->decimal('total_amount', 18, 2);
            $table->decimal('discount', 18, 2)->default(0);
            $table->decimal('final_amount', 18, 2);
            $table->string('status')->default('pending'); // pending, confirmed, processing, completed, cancelled
            $table->text('notes')->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('sql_server_fich_id')->nullable(); // ID в SQL Server после синхронизации
            $table->boolean('synced_to_sqlserver')->default(false);
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
            
            $table->index('order_number');
            $table->index('status');
            $table->index('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('orders');
    }
};
