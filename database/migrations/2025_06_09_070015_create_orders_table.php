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
            $table->string('delivery_method'); // pickup/delivery
            $table->string('phone');
            $table->string('customer_name');
            $table->string('address')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('status')->default('new');
            $table->string('payment_status')->default('pending');
            $table->string('received_status')->default('pending'); // Новое поле
            $table->timestamp('paid_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
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
