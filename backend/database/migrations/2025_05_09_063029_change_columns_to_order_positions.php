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
        Schema::table('order_items', function (Blueprint $table) {
            Schema::table('order_positions', function (Blueprint $table) {
                $table->renameColumn('product_name', 'title');
                $table->renameColumn('preview_image', 'preview_image_path');
                $table->string('type')->after('order_id')->default('product')->nullable();
                $table->string('link_url')->after('product_id')->nullable();
                $table->boolean('calculated')->after('unit_price')->default(true)->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('order_positions', function (Blueprint $table) {

            Schema::table('order_positions', function (Blueprint $table) {
                $table->renameColumn('title', 'product_name');
                $table->renameColumn('preview_image_path', 'preview_image');
                $table->dropColumn('type');
                $table->dropColumn('link_url');
                $table->dropColumn('calculated');
            });
        });
    }
};
