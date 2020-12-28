<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_hospitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->year('since');
            $table->mediumText('address');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark');
            $table->mediumText('mobile_no');
            $table->mediumText('contact_numbers');
            $table->mediumText('email_address');
            $table->mediumText('website');
            $table->mediumText('profile_image');
            $table->mediumText('about_us');
            $table->mediumText('other_description')->nullable();
            $table->tinyInteger('is_branch')->default(1);
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
        Schema::dropIfExists('lmr_hospitals');
    }
}
