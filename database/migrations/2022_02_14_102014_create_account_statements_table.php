<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_statements', function (Blueprint $table) {
            $table->id();
            $table->string('description'); 
            $table->dateTime('date');
            $table->date('date_search');
            $table->string('debit')->nullable(); //payment
            $table->string('credit')->nullable(); //invoice
            $table->string('balance')->nullable();
            $table->string('accountType');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->foreignId('payment_id')->nullable()->constrained('payment_invoices');

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
        Schema::dropIfExists('account_statements');
    }
}
