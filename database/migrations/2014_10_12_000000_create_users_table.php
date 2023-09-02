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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('payment_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('date_first_purchase')->nullable();
            $table->string('role')->default('User');
            $table->string('expiry_date')->nullable();
            $table->string('card_number')->nullable();
            $table->float('paidamount')->nullable();
            $table->float('remainingamount')->nullable();
            $table->json('items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
