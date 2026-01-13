<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_numbers', function (Blueprint $table) {
            $table->integer('year')->default(date('Y'))->after('last_number');
            $table->integer('month')->default(date('m'))->after('year');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_numbers', function (Blueprint $table) {
            $table->dropColumn(['year', 'month']);
        });
    }
};

