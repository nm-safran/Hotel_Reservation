<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_guests');
            $table->enum('status', ['confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show']);
            $table->text('special_requests')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_expiry')->nullable();
            $table->string('credit_card_name')->nullable();
            $table->boolean('has_credit_card')->default(false);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->boolean('is_block_booking')->default(false);
            $table->integer('number_of_rooms')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
