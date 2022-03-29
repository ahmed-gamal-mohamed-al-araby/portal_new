<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNatureDealingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nature_dealings', function (Blueprint $table) {
            $table->id();
            $table->string("name_en")->nullable();
            $table->string("name_ar");
            $table->string("code");
            $table->foreignId("discount_type_id")->constrained("discount_types");
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
        Schema::dropIfExists('nature_dealings');
    }
}
