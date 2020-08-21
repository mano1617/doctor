<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldSelfReg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_phys_clinic_consulting', function (Blueprint $table) {
            $table->enum('self_register', ['0', '1'])->default('0')->comment('0 is not register, 1 is registered')
                ->after('clinic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lmr_phys_clinic_consulting', function (Blueprint $table) {
            //
        });
    }
}
