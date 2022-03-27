<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('place_delivery');
            $table->string('currency');
            $table->string('type_discount')->nullable();
            $table->string('payment_terms');
            $table->text('general_terms');
            $table->foreignId('requester_id')->constrained('users');
            $table->string('suppling_duration');
            $table->string('total_gross');
            $table->integer('taxes');
            $table->integer('discount');
            $table->string('total_after_discount');
            $table->string('with_holding')->nullable();
            $table->string('net_total');
            $table->boolean('exist_comment')->default(0);

            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->boolean('approved')->default(0);
            $table->boolean('sent')->default(0);
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
        Schema::dropIfExists('purchase_orders');
    }
}
