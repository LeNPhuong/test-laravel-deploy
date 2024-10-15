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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId(column: 'status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->float('trans_amount');
            $table->string('note',191);
            $table->tinyInteger('payment_method');
            $table->timestamp('trans_date');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_transactions');
    }
};
