<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_work_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('parent_type');
            $table->unsignedBigInteger('parent_id');
            $table->enum('day_name',['monday','tuesday','wednesday','thursday','friday', 'saturday', 'sunday','others']);
            $table->mediumText('morning_session_time')->comment('Use "-" for splitup 10:00:00-13:00:00,');
            $table->mediumText('evening_session_time')->comment('Use "-" for splitup 10:00:00-13:00:00,');
            $table->enum('status',['0','1','2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_pharmacy_wrk_times');
    }
}
