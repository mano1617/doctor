<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrPhysClinicConsultWrkDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_phys_clinic_consult_wrk_day', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('consulting_id');
            $table->enum('day_name',['monday','tuesday','wednesday','thursday','friday', 'saturday', 'sunday','others']);
            $table->mediumText('morning_session_time')->comment('Use "-" for splitup 10:00:00-13:00:00,');
            $table->mediumText('evening_session_time')->comment('Use "-" for splitup 10:00:00-13:00:00,');
            $table->enum('status',['0','1','2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('lmr_physician_clinic')->onDelete('cascade');
            $table->foreign('consulting_id')->references('id')->on('lmr_phys_clinic_consulting')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_phys_clinic_consult_wrk_day');
    }
}
