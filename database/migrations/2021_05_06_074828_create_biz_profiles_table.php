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
            $table->integer('user_id');
            $table->char('name', 200);
            $table->string('logo')->nullable();
            $table->boolean('registered');
            $table->string('reg_number')->nullable();
            $table->string('reg_date')->nullable();
            $table->string('location');
            $table->string('industry');
            $table->string('biz_phase');
            $table->bigInteger('num_employees');
            $table->bigInteger('annual_turnover');
            $table->bigInteger('monthly_turnover');
            $table->text('offering');
            $table->date('start_date');
            $table->date('premise_start_date');
            $table->string('company_bank');
            $table->string('card_to_perc');
            $table->string('cash_to_perc');
            $table->string('eft_to_perc');
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
