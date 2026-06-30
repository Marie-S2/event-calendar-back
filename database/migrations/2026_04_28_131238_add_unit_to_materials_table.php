<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('unit')->default('unité')->after('quantity');
            $table->boolean('is_divisible')->default(false)->after('unit');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
             $table->dropColumn(['unit', 'is_divisible']);
        });
    }
};




   