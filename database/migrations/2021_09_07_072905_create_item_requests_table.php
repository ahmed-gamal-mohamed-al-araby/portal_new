<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('family_name_id')->constrained('family_names');
            $table->text('specification');
            $table->string('file')->nullable();
            $table->string('comment_reason')->nullable();
            $table->integer('quantity');
            $table->integer('stock_quantity');
            $table->integer('actual_quantity');
            $table->integer('used_quantity');
            $table->string('comment_refuse')->nullable();
            $table->foreignId('unit_id')->constrained('units');
            $table->enum('priority',['L', 'M', 'H'])->comment('L: Low, M: Medium, H: High');
            $table->text('factory_specification')->nullable();
            $table->integer('reserved_quantity')->nullable();
            $table->date('max_date_delivery')->nullable();
            $table->date('start_date_supply')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('approved')->default(1);
            $table->text('edit_specification')->nullable();
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
        Schema::dropIfExists('item_requests');
    }
}
