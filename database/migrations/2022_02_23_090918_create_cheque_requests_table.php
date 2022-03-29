<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_requests', function (Blueprint $table) {
            $table->id();
            $table->string('cheque_number');
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('type_ord_okay');
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->string('cheque_value');
            $table->string('value_letter');
            $table->string('total_debit');
            $table->string('total_balance');
            $table->integer('order_number')->constrained('purchase_orders')->nullable();
            $table->integer('invoice_number')->nullable();
            $table->string('operation_name')->nullable();
            $table->string('balance');
            $table->boolean('exist_comment')->default(0);

            $table->boolean('sent')->default(0);
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
        Schema::dropIfExists('cheque_requests');
    }
}
