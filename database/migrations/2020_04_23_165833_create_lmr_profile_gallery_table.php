<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmrProfileGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_profile_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('name');
            $table->mediumText('file_name');
            $table->dateTime('date_added');
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('lmr_profile_gallery');
    }
}
