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
        Schema::connection('pgsql')->create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_tm');
            $table->string('name_ru')->nullable();
            $table->string('name_en')->nullable();
            $table->string('image')->nullable(); // путь или url к изображению категории
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('product_categories');
    }
};
