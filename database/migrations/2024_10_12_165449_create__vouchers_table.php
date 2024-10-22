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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->boolean('active')->default(true); // Trạng thái active (true/false)
            $table->enum('discount_type', ['percentage', 'fixed_amount'])->default('percentage');
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount_value', 10, 2)->nullable();
            $table->string('description', 255);
            $table->integer('quantity');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_vouchers');
    }
};
