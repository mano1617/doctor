<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrOtpVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_otp_verification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('otp_type')->comment('user_mobile,clinic,extra...');
            $table->mediumText('otp');
            $table->mediumText('mobile_no');
            $table->dateTime('verified_at');
            $table->dateTime('expire_at');
            $table->mediumText('description');
            $table->enum('verified_status',['0','1','2'])->default('0')->comment('0 is not verified, 1 is verified, 2 is expired');
            $table->enum('status',['0','1','2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_otp_verification');
    }
}
