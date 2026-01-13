<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('client_branches')->onDelete('set null');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->string('jobtitle')->nullable();
            $table->string('address')->nullable();
            $table->string('subject')->nullable();
            $table->string('invoice_number')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('addclients')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
