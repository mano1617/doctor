<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeFieldLmrPhysicianClinic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_physician_clinic', function (Blueprint $table) {
            $table->tinyInteger('clinic_type')->default(1)->after('id')->comment('1 is clinic, 2 is branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lmr_physician_clinic', function (Blueprint $table) {
            //
        });
    }
}
