<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtdailyactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtdailyactivity', function (Blueprint $table) {
            $table->id('dailyactivityid');
            $table->integer('dailyactivitycatid')->nullable();
            $table->integer('dailyactivitytypeid')->nullable();
            $table->text('dailyactivitytypevalue')->nullable();
            $table->date('dailyactivitydate')->nullable();
            $table->text('dailyactivitydesc')->nullable();
            $table->text('dailyactivityloc')->nullable();
            $table->double('dailyactivitylatitude')->nullable();
            $table->double('dailyactivitylongitude')->nullable();

            $table->bigInteger('createdby')->nullable();
            $table->timestamp('createddate')->useCurrent();
            $table->bigInteger('updatedby')->nullable();
            $table->timestamp('updateddate')->useCurrent();
            $table->boolean('isactive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vtdailyactivity');
    }
}
