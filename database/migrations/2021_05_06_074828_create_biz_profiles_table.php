<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBizProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biz_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('entr_id');
            $table->char('name', 200);
            $table->boolean('registered');
            $table->string('reg_number')->nullable();
            $table->string('location');
            $table->string('industry');
            $table->string('biz_phase');
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
        Schema::dropIfExists('biz_profiles');
    }
}
