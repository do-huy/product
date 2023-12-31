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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->string('name');
            $table->integer('amount');
            $table->unsignedDouble('price');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_item_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreign('bill_id')
                ->references('id')
                ->on('bills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_details');
    }
};
