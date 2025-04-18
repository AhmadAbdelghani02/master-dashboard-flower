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
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->timestamp('order_date')->useCurrent();
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('shipping_address_id')->constrained('addresses', 'address_id');
            $table->foreignId('billing_address_id')->constrained('addresses', 'address_id');
            $table->string('status', 20)->default('pending');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
