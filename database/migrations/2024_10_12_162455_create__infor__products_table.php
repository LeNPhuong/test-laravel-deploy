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
        Schema::create('infor__products', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'product_id')->nullable()->constrained('product')->onDelete('set null');
            $table->string('brand',255);
            $table->string('origin',191);
            $table->string('purpose',255);
            $table->string('ingredient',255);
            $table->string('instructions',500);
            $table->string('preservation',500);
            $table->timestamp('created_at');
            $table->timestamp('update_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_infor__products');
    }
};
