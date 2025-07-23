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
        Schema::table('order_positions', function (Blueprint $table) {
            $table->integer('converted_price_rub')->nullable()->change();
            $table->integer('price_cny')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_positions', function (Blueprint $table) {
            $table->decimal('converted_price_rub', 10, 2)->nullable()->change();
            $table->decimal('price_cny', 10, 2)->nullable()->change();
        });
    }
};
