<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('sortname');
            $table->mediumText('name');
            $table->integer('phonecode');
            $table->enum('status',['0','1','2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_countries');
    }
}
