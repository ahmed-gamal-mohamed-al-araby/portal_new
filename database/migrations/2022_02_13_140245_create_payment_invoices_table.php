<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->string("po_number")->nullable();
            $table->string("invoice_number")->nullable();
            $table->string("notes")->nullable();
            $table->enum("payment_method",["cashe","cheque","bank_transfer"]);
            $table->date("date_payment");
            $table->string("exchange_rate")->nullable();
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->foreignId('supplier_bank_id')->nullable()->constrained('supplier_bank_transfers');
            $table->string("cheque_number")->nullable();
            $table->string("value")->nullable();
            $table->date("date_delivery")->nullable();
            $table->string("recipient_name")->nullable();
            $table->string('file_name')->nullable();
            $table->string('original_name')->nullable();

            $table->boolean('approved')->default('0');
            $table->foreignId("user_id")->constrained("users");

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
        Schema::dropIfExists('payment_invoices');
    }
}
