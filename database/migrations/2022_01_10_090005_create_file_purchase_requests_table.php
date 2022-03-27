<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePurchaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();

            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_purchase_requests');
    }
}
