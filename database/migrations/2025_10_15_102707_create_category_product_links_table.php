<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->create('category_product_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // из product_categories
            $table->integer('material_id');            // из tbl_mg_materials (SQL Server)
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('category_product_links');
    }
};
