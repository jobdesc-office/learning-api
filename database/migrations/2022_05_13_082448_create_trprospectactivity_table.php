<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrprospectActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trprospectactivity', function (Blueprint $table) {
            $table->id('prospectactivityid');
            $table->integer('prospectactivityprospectid');
            $table->integer('prospectactivitycatid')->nullable();
            $table->integer('prospectactivitytypeid')->nullable();
            $table->date('prospectactivitydate')->nullable();
            $table->text('prospectactivitydesc')->nullable();
            $table->text('prospectactivityloc')->nullable();
            $table->double('prospectactivitylatitude')->nullable();
            $table->double('prospectactivitylongitude')->nullable();

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
        Schema::dropIfExists('trprospectactivity');
    }
}
