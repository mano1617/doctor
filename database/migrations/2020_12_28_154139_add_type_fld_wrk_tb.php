<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeFldWrkTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_phys_clinic_working_day', function (Blueprint $table) {
            $table->mediumText('clinic_type')->after('clinic_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lmr_phys_clinic_working_day', function (Blueprint $table) {
            //
        });
    }
}
