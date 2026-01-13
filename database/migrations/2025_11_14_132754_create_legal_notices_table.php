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
        Schema::create('legal_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('addclients')->onDelete('cascade');
            $table->unsignedBigInteger('notice_category_id');
            $table->foreign('notice_category_id')->references('id')->on('legal_notice_categories')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('client_branches')->onDelete('restrict');
            $table->index('branch_id');
            $table->string('loan_account_acquest_cin')->nullable();
            $table->date('legal_notice_date')->nullable();
            $table->string('name');
            $table->date('dateline_for_filing')->nullable();
            $table->longText('comments')->nullable();
            $table->enum('status', ['Running', 'Done', 'Reject'])->default('Running');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_notices');
    }
};
