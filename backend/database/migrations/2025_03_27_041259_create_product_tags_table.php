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
        Schema::create('product_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->nullable()->index()->constrained('tags');
            $table->foreignId('product_id')->nullable()->index()->constrained('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::table('product_tag', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tag_id');
            $table->dropConstrainedForeignId('product_id');
        });
        Schema::dropIfExists('product_tag');
    }
};
