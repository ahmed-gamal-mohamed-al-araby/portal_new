<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            // $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete("CASCADE");
            $table->foreignId('item_order_id')->constrained('item_orders')->onDelete("CASCADE");
            $table->integer('quantity_received')->nullable();
            $table->integer('receipt_number');
            $table->dateTime('recipient_date');
            $table->text('location');
            $table->softDeletes();
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
        Schema::dropIfExists('material_receipts');
    }
}
