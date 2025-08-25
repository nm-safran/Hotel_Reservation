<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('company_name')->nullable(); // For travel companies
            $table->boolean('is_company')->default(false);
            $table->decimal('discount_rate', 5, 2)->default(0); // For travel companies
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
