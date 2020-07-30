<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProfilePhysiEduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_profile_physician_education', function (Blueprint $table) {
            DB::statement('ALTER TABLE `lmr_profile_physician_education` CHANGE `additional_qualification` `college_name` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
            $table->mediumText('join_year')->after('college_name');
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
        Schema::table('lmr_profile_physician_education', function (Blueprint $table) {
        });
    }
}
