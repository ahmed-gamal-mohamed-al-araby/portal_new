<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryPurchaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->nullable()->constrained('purchase_requests');
            $table->foreignId('item_request_id')->nullable()->constrained('item_requests');
            $table->string('send_message')->nullable();
            $table->string('receive_message')->nullable();
            $table->string('edit_item')->nullable();
            $table->string('approve')->default(0);
            $table->foreignId('send_id')->nullable()->constrained('users');
            $table->foreignId('receive_id')->nullable()->constrained('users');
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('alternate')->nullable();
            $table->integer('technical_office');
            $table->string('approve_technical_office')->default(0);
            $table->dateTime('aprove_first_date')->nullable();
            $table->dateTime('aprove_last_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiry_purchase_requests');
    }
}
