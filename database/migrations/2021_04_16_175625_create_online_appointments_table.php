<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_appointments', function (Blueprint $table) {
            $table->id();
            $table->mediumText('text');
            $table->dateTime('time_from');
            $table->dateTime('time_to');

            $table->dateTime('day_of_week');
            $table->dateTime('date_record');


            $table->softDeletes();
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
        Schema::dropIfExists('online_appointments');
    }
}
