<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrPhysBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_phys_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->mediumText('address');
            $table->mediumText('district');
            $table->mediumText('state');
            $table->mediumText('country');
            $table->mediumText('pincode');
            $table->mediumText('landmark')->nullable();
            $table->mediumText('email_address');
            $table->mediumText('website');
            $table->mediumText('mobile_no');
            $table->mediumText('landline')->nullable();
            $table->mediumText('map_image')->nullable();
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
        Schema::dropIfExists('lmr_phys_branches');
    }
}
