<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLmrUpdateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmr_galleries', function (Blueprint $table) {
            $table->mediumText('parent_type')->nullable()->after('id');
            $table->unsignedBigInteger('parent_id')->after('parent_type');
            $table->dateTime('uploaded_at')->after('sorting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lmr_galleries', function (Blueprint $table) {
            //
        });
    }
}
