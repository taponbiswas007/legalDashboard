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
        Schema::create('legal_notice_pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('category_id');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Add foreign keys
            $table->foreign('client_id')
                ->references('id')
                ->on('addclients')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('legal_notice_categories')
                ->onDelete('cascade');

            // Add unique constraint - one price per client+category combo
            $table->unique(['client_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_notice_pricings');
    }
};
