<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProfilePhysiAddEduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_physician_add_edu', function (Blueprint $table) {
            DB::statement('ALTER TABLE `lmr_physician_add_edu` CHANGE `description` `professional_qualification` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
            $table->mediumText('branch')->after('professional_qualification');
            $table->mediumText('college')->after('branch');
            $table->mediumText('join_year')->after('college');
            $table->mediumText('place')->after('join_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lmr_physician_add_edu', function (Blueprint $table) {
            //
        });
    }
}
