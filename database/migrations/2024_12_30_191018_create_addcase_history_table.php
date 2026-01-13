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
        Schema::create('addcase_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('client_branches')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('addclients')->onDelete('cascade');
            $table->string('file_number');
            $table->string('previous_date')->nullable();
            $table->string('previous_step')->nullable();
            $table->unsignedBigInteger('court_id')->nullable();
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');
            $table->string('court_name')->nullable();
            $table->string('case_number');
            $table->string('name_of_parties');
            $table->string('section')->nullable();
            $table->string('loan_account_acquest_cin')->nullable();
            $table->string('legal_notice_date')->nullable();
            $table->string('filing_or_received_date')->nullable();
            $table->string('next_hearing_date')->nullable();
            $table->string('next_step')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_final')->default(false);
            $table->string('legal_notice')->nullable();
            $table->string('plaints')->nullable();
            $table->string('others_documents')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addcase_history');
    }
};
