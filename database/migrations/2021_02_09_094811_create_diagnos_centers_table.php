<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_diagnos_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->year('since')->nullable();
            $table->mediumText('address');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark')->nullable();
            $table->mediumText('mobile_no');
            $table->mediumText('landline')->nullable();
            $table->mediumText('email_address');
            $table->mediumText('website')->nullable();
            $table->mediumText('map_image')->nullable();
            $table->mediumText('profile_image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('other_description')->nullable();
            $table->enum('have_branch',['0','1'])->default('0')->comment('0 is no branch, 1 is have branch');
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
        Schema::dropIfExists('lmr_diagnos_centers');
    }
}
