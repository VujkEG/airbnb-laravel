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
        // Menjamo ime tabele iz 'products' u 'apartmani'
        Schema::rename('products', 'apartmani');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // U slučaju vraćanja migracije, vraća se na staro ime
        Schema::rename('apartmani', 'products');
    }
};