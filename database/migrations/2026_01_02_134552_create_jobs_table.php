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
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('auth_id')->nullable()->after('id');
                $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('title');
                $table->text('description');
                $table->string('job_type')->nullable();
                $table->string('location')->nullable();
                $table->string('salary_range')->nullable();
                $table->date('deadline');
                $table->string('pdf_file')->nullable();
                $table->boolean('is_published')->default(false);
                $table->integer('total_applications')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
