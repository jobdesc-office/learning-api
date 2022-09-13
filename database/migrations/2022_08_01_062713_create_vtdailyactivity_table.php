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
        pgsql()->create('vtdailyactivity', function (Blueprint $table) {
            $table->id('dayactid');
            $table->integer('dayactcatid')->nullable();
            $table->integer('dayactcustid')->nullable();
            $table->integer('dayacttypeid')->nullable();
            $table->text('dayacttypevalue')->nullable();
            $table->date('dayactdate')->nullable();
            $table->text('dayactdesc')->nullable();
            $table->text('dayactloclabel')->nullable();
            $table->text('dayactloc')->nullable();
            $table->double('dayactlatitude')->nullable();
            $table->double('dayactlongitude')->nullable();

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
        pgsql()->dropIfExists('vtdailyactivity');
    }
}
