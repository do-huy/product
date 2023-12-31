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
        Schema::create('product_item_options', function (Blueprint $table) {
            $table->unsignedBigInteger('product_item_id');
            $table->unsignedBigInteger('variant_option_id');
            $table->primary(['product_item_id', 'variant_option_id']);
            $table->foreign('product_item_id')->references('id')->on('product_items')->cascadeOnDelete();
            $table->foreign('variant_option_id')->references('id')->on('variant_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_item_options');
    }
};
