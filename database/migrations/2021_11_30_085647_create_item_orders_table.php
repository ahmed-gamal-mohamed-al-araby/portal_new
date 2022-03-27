<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('total');
            $table->string('price');
            $table->foreignId('unit_id')->constrained('units');
            $table->integer('item_request_id');
            $table->text('comment')->nullable();
            $table->text('comment_refuse')->nullable();
            $table->boolean('approved')->default(1);
            $table->string('comment_reason')->nullable();
            $table->string('comment_item_refuse')->nullable();
            $table->integer('used_quantity');

            $table->text('specification')->nullable();
            $table->text('unit_new')->nullable();
            $table->text('comment_change_reason')->nullable();

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
        Schema::dropIfExists('item_orders');
    }
}
