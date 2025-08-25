<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->decimal('room_charges', 10, 2);
            $table->decimal('service_charges', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'credit_card']);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->text('payment_details')->nullable();
            $table->boolean('is_no_show_charge')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billings');
    }
};
