<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('file_refused')->nullable();
            $table->string('file_name')->nullable();

            $table->foreignId('purchase_order_id')->constrained('purchase_orders');
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
        Schema::dropIfExists('file_purchase_orders');
    }
}
