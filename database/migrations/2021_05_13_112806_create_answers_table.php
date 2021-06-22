<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('assessment_id');
            $table->integer('category_id');
            $table->integer('biz_score_id');
            $table->integer('biz_id');
            $table->boolean('answer');
            $table->text('recom');
            $table->text('outcome');
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
        Schema::dropIfExists('answers');
    }
}
