<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoice_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('prefix')->default('INV-'); // optional
            $table->integer('last_number')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_numbers');
    }
};
