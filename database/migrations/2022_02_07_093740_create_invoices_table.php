<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->foreignId('business_nature_id')->nullable()->constrained('business_natures');
            $table->string("covenant_type")->nullable();
            $table->string("detection_number")->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->foreignId('po_id')->nullable()->constrained('purchase_orders');
            $table->date("date_invoice")->nullable();
            $table->string("invoice_number")->nullable();
            $table->text("specifications")->nullable();
            $table->string("price");
            $table->integer("amount")->default(1);
            $table->string("total");
            $table->integer("value_tax_rate")->nullable();
            $table->string("value_tax")->nullable();
            $table->string("overall_total")->nullable();
            $table->integer("other_discount")->nullable();
            $table->string("total_after_discount")->nullable();
            $table->string("restrained_type")->nullable()->default("not_restrained");
            $table->foreignId('nature_dealing_id')->nullable()->constrained('nature_dealings');
            $table->string("expense_type")->nullable()->default("cashe");
            $table->string("tax_deduction")->nullable();
            $table->string("tax_deduction_value")->nullable();
            $table->string("net_total")->nullable();
            $table->integer("business_insurance_rate")->nullable();
            $table->string("business_insurance_value")->nullable();
            $table->string("net_total_after_business_insurance")->nullable();
            $table->string("notes")->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
