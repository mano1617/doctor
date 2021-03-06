<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrPhysicianClinicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_physician_clinic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->mediumText('address');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark');
            $table->mediumText('mobile_no');
            $table->mediumText('landline');
            $table->mediumText('email_address');
            $table->mediumText('website');
            $table->mediumText('map_image');
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
        Schema::disableForeignKeyConstraints();
        Schema::table('lmr_physician_clinic', function ($table) {
            $table->dropForeign('lmr_physician_clinic_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('lmr_physician_clinic');
    }
}
