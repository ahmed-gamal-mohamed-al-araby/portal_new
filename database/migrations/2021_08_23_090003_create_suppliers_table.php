<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 255)->unique()->nullable();
            $table->string('name_en', 255)->unique()->nullable();
            $table->string('fax', 25)->nullable();

            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('cascade');

            $table->string('phone', 16)->nullable();
            $table->string('mobile', 16)->nullable();

            $table->string('email', 255)->nullable();
            $table->string('website_url',520)->nullable();
            $table->string('gmap_url',520)->nullable();

            $table->string('logo')->nullable();

            $table->text('person_note')->nullable();
            $table->text('family_name_note')->nullable();
            $table->text('accredite_note')->nullable();

            $table->string('tax_id_number')->nullable();
            $table->string('tax_id_number_file')->nullable();
            $table->string('commercial_registeration_number')->nullable();
            $table->string('commercial_registeration_number_file')->nullable();
            $table->string('value_add_registeration_number')->nullable();
            $table->string('value_add_registeration_number_file')->nullable();
            $table->string('value_add_tax_number')->nullable();
            $table->string('tax_file_number_file')->nullable();

            $table->boolean('cash')->nullable();
            $table->boolean('system')->default(0);
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
        Schema::dropIfExists('suppliers');
    }
}
