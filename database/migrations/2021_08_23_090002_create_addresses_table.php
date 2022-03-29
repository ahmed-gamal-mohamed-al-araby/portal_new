<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('governorate_id')->nullable()->constrained('governorates');
            $table->string('city_ar', 75)->nullable();
            $table->string('city_en', 75)->nullable();
            $table->string('street_ar', 100)->nullable();
            $table->string('street_en', 100)->nullable();
            $table->string('building_no', 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
