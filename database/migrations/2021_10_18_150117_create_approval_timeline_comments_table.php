<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalTimelineCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_timeline_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->text('comment_approve')->nullable();
            $table->text('image_approve')->nullable();
            $table->text('name_image_approve')->nullable();
            $table->foreignId('approval_timeline_id')->constrained('approval_timelines');
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
        Schema::dropIfExists('approval_timeline_comments');
    }
}
