<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_hospital_consultants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hospital_id');
            $table->enum('self_register', ['0', '1'])->default('0')->comment('0 is not register, 1 is registered');
            $table->mediumText('name');
            $table->mediumText('speciality');
            $table->mediumText('email_address');
            $table->mediumText('mobile_no');
            $table->mediumText('monthly_visit');
            $table->mediumText('others');
            $table->mediumText('description');
            $table->enum('status',['0','1','2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('lmr_hospitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_hospital_consultants');
    }
}
