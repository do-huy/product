<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cart\app\Models\CartItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->string('name');
            $table->integer('amount');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_item_id')->nullable();
            $table->text('note')->nullable();
            $table->unsignedTinyInteger('is_selected')->default(CartItem::IS_SELECTED);
            $table->timestamps();

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
