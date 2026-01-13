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
        Schema::create('legal_notice_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->date('bill_date');
            $table->decimal('total_amount', 12, 2);
            $table->string('pdf_path')->nullable();
            $table->json('filters')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('addclients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_notice_bills');
    }
};
