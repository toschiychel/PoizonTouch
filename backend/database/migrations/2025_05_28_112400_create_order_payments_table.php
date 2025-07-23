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
        {
            Schema::create('order_payments', function (Blueprint $table) {
                $table->id();

                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->string('gateway', 50);
                $table->string('gateway_id')->nullable();
                $table->decimal('amount', 15, 2);
                $table->string('currency', 3)->default('USD');
                $table->string('status', 20)->default('initiated')->comment('Payment status: initiated, pending, succeeded, failed');
                $table->json('meta')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
