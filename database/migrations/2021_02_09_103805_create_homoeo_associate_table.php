<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomoeoAssociateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_homoeo_associate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->year('since')->nullable();
            $table->mediumText('region_circle')->nullable();
            $table->mediumText('moto')->nullable();
            $table->mediumText('email_address');
            $table->mediumText('website')->nullable();
            $table->longText('description')->nullable();

            $table->mediumText('admin_name');
            $table->mediumText('mobile_no');
            $table->longText('bearers')->nullable();
            $table->longText('members')->nullable();
            $table->longText('latest_news')->nullable();
            $table->longText('new_events')->nullable();
            $table->longText('posts')->nullable();
            $table->longText('notifications')->nullable();
            
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
        Schema::dropIfExists('lmr_homoeo_associate');
    }
}
