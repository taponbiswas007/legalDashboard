<?php
// d:/web_development/live_web_project/sk_sharif_project/database/migrations/2026_01_10_legal_notice_bill_items.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('legal_notice_bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_id')->nullable();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('legal_notice_bill_id');
            $table->string('type')->nullable(); // e.g. service, fee, tax, discount
            $table->unsignedBigInteger('reference_id')->nullable(); // e.g. legal_notice_id or other
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('legal_notice_bill_id')
                ->references('id')->on('legal_notice_bills')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('legal_notice_bill_items');
    }
};
