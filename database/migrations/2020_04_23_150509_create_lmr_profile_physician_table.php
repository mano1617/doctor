<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrProfilePhysicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_profile_physician', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('gender',['male','female','transgender']);
            $table->mediumText('avatar');
            $table->mediumText('address');
            $table->date('dob');
            $table->tinyInteger('age');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark')->nullable();
            $table->mediumText('mobile_no');
            $table->mediumText('landline')->nullable();
            $table->longText('about_me')->nullable();
            $table->mediumText('map_image')->nullable();
            $table->mediumText('qr_code')->nullable();
            $table->enum('has_branches',['0','1','2'])->default('0')->comment('0 is no branches, 1 branches available');
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
        Schema::dropIfExists('lmr_profile_physician');
    }
}
