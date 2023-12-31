<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Voucher\app\Models\Voucher;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('use_for')->default(Voucher::USE_FOR_ALL);
            $table->tinyInteger('status')
                ->default(Voucher::STATUS_INACTIVE)
                ->comment(Voucher::STATUS_ACTIVE . ': active, ' . Voucher::STATUS_INACTIVE . ': inactive');
            $table->dateTime('start_at');
            $table->dateTime('expire_at');
            $table->tinyInteger('type')
                ->comment(Voucher::TYPE_PERCENT . ': percentage, ' . Voucher::TYPE_FIX . ': VND amount');
            $table->unsignedDouble('discount_amount');
            $table->unsignedDouble('max_discount_amount')->nullable();
            $table->unsignedDouble('min_order_amount')->nullable();
            $table->integer('apply_count')->default(0);
            $table->integer('quantity')->nullable();
            $table->integer('apply_time')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
