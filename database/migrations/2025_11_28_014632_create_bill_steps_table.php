<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillStepsTable extends Migration
{
    public function up()
    {
        Schema::create('bill_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('step_name');
            $table->decimal('rate', 14, 2)->default(0);
            $table->string('case_number')->nullable();
            $table->date('hearing_date')->nullable();
            $table->timestamps();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('client_branches')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_steps');
    }
}
