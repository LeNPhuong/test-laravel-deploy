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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId(column: 'transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->foreignId(column: 'status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->foreignId(column: 'voucher_id')->nullable()->constrained('vouchers')->onDelete('set null');
            $table->float('total_amount');
            $table->float('total_amount_after_sale');
            $table->enum('delivery_method',['fast', 'normal'])->default('normal');
            $table->timestamp('order_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_orders');
    }
};
