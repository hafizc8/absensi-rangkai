<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_absensis', function (Blueprint $table) {
            $table->id();
            $table->string('jam_masuk');
            $table->string('jam_pulang');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('jarak_toleransi');
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
        Schema::dropIfExists('setting_absensis');
    }
}
