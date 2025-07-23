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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable()->after('password');
            $table->string('patronymic')->nullable()->after('surname');
            $table->unsignedInteger('age')->nullable()->after('patronymic');
            $table->string('address')->nullable()->after('age');
            $table->unsignedSmallInteger('gender')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('patronymic');
            $table->dropColumn('age');
            $table->dropColumn('address');
            $table->dropColumn('gender');
        });
    }
};
