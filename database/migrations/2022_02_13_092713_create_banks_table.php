<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code')->unique();
            $table->string('bank_account_number');
            $table->string('bank_name');
            $table->string('bank_branch')->nullable();
            $table->string('currency');
            $table->string('bank_ibn')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_address')->nullable();
            $table->boolean('approved')->default('0');
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
        Schema::dropIfExists('banks');
    }
}
