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
        Schema::create('gift_boxes', function (Blueprint $table) {
            $table->id('box_id');
            $table->foreignId('order_id')->nullable()->constrained('orders', 'order_id')->onDelete('set null');
            $table->foreignId('flower_id')->constrained('products', 'product_id');
            $table->foreignId('chocolate_id')->constrained('products', 'product_id');
            $table->foreignId('packaging_id')->constrained('products', 'product_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->text('custom_message')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_boxes');
    }
};
