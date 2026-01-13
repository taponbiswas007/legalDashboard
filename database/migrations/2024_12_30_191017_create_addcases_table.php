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
        Schema::create('addcases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('addclients')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('client_branches')->onDelete('set null');
            $table->string('file_number');
            $table->date('previous_date')->nullable();
            $table->string('previous_step')->nullable();
            $table->unsignedBigInteger('court_id')->nullable();
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');
            $table->string('court_name')->nullable();
            $table->string('case_number');
            $table->string('section')->nullable();
            $table->string('name_of_parties');
            $table->date('legal_notice_date')->nullable();
            $table->date('filing_or_received_date');
            $table->date('next_hearing_date')->nullable();
            $table->string('next_step')->nullable();
            $table->string('loan_account_acquest_cin')->nullable();
            $table->string('legal_notice')->nullable();
            $table->string('plaints')->nullable();
            $table->string('others_documents')->nullable();
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addcases');
    }
};
