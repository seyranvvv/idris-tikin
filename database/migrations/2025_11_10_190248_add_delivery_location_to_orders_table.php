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
        Schema::connection('pgsql')->table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_location_id')->nullable()->after('customer_address');
            $table->foreign('delivery_location_id')->references('id')->on('delivery_locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->table('orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_location_id']);
            $table->dropColumn('delivery_location_id');
        });
    }
};
