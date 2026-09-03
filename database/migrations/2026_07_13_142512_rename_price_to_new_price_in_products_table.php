<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('products', 'price') && !Schema::hasColumn('products', 'new_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('price', 'new_price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'new_price') && !Schema::hasColumn('products', 'price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('new_price', 'price');
            });
        }
    }
};