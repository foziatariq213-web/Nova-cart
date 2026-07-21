// database/migrations/xxxx_add_gift_mood_fields_to_products_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Gift Finder Fields
            $table->string('gift_occasion')->nullable(); // Birthday, Anniversary, Wedding, etc.
            $table->string('gift_recipient')->nullable(); // For Her, For Him, For Kids, etc.
            $table->string('gift_category')->nullable(); // Luxury, Budget, Personalized, etc.
            $table->decimal('gift_price_range_min', 10, 2)->nullable();
            $table->decimal('gift_price_range_max', 10, 2)->nullable();
            
            // Mood Fields
            $table->string('mood_type')->nullable(); // Happy, Sad, Romantic, etc.
            $table->string('mood_emotion')->nullable(); // Excited, Calm, Energetic, etc.
            $table->string('mood_color')->nullable(); // Red, Blue, Green, etc.
            $table->string('mood_season')->nullable(); // Summer, Winter, Spring, Fall
            
            // Additional Fields
            $table->string('gift_style')->nullable(); // Modern, Classic, Vintage, etc.
            $table->boolean('is_gift')->default(false);
            $table->boolean('is_personalized')->default(false);
            $table->text('gift_message')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'gift_occasion',
                'gift_recipient',
                'gift_category',
                'gift_price_range_min',
                'gift_price_range_max',
                'mood_type',
                'mood_emotion',
                'mood_color',
                'mood_season',
                'gift_style',
                'is_gift',
                'is_personalized',
                'gift_message'
            ]);
        });
    }
};