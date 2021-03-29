<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomoeoInstitutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_homoeo_institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->mediumText('since');
            $table->mediumText('address');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark')->nullable();
            $table->mediumText('mobile_no');
            $table->mediumText('email_address');
            $table->mediumText('website')->nullable();
            $table->mediumText('profile_image')->nullable();
            $table->mediumText('about_us')->nullable();
            $table->mediumText('contact_nos')->nullable();
            $table->longText('achievements')->nullable();
            $table->mediumText('courses')->nullable();
            $table->mediumText('courses_ug')->nullable();
            $table->mediumText('courses_pg')->nullable();
            $table->longText('acreditations')->nullable();
            $table->longText('opd_hospital')->nullable();
            $table->longText('ipd_hospital')->nullable();

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
        Schema::dropIfExists('lmr_homoeo_institutions');
    }
}
