<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProQualificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmr_mstr_pro_qualify', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('name');
            $table->enum('status', ['0', '1', '2'])->default('1')->comment('0 is deactive, 1 is active, 2 is removed');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lmr_mstr_pro_qualify');
    }
}
