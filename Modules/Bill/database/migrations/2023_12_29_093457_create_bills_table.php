<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Bill\app\Models\Bill;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('address');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->enum('payment', [
                    Bill::PAYMENT_PAY,
                    Bill::PAYMENT_DEBT
                ])
                ->default(Bill::PAYMENT_DEBT);
            $table->enum('status', [
                    Bill::STATUS_NEW,
                    Bill::STATUS_PACKING,
                    Bill::STATUS_TRANSPORT,
                    Bill::STATUS_SUCCESS,
                    Bill::STATUS_REFUND,
                    Bill::STATUS_ERROR,
                ])
                ->default(Bill::STATUS_NEW);
            $table->unsignedDouble('total');
            $table->unsignedDouble('tax')->default(0);
            $table->unsignedBigInteger('seller_voucher_id')->nullable();
            $table->unsignedBigInteger('platform_voucher_id')->nullable();
            $table->unsignedDouble('seller_discount')->nullable();
            $table->unsignedDouble('platform_discount')->nullable();
            $table->unsignedDouble('shipping_fee')->default(0);
            $table->text('note')->nullable();
            $table->timestamp('transport_at')->nullable();
            $table->timestamp('success_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
