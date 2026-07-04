<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apartmani', function (Blueprint $table) {
            // Dodajemo slug polje koje može biti unikatno
            $table->string('slug')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('apartmani', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};