<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtattendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('vtattendance', function (Blueprint $table) {
            $table->id('attid');
            $table->bigInteger('attbpid')->nullable();
            $table->bigInteger('attuserid')->nullable();
            $table->date('attdate')->nullable();
            $table->time('attclockin')->nullable();
            $table->time('attclockout')->nullable();
            $table->double('attlat')->nullable();
            $table->double('attlong')->nullable();
            $table->text('attaddress')->nullable();

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
        pgsql()->dropIfExists('vtattendance');
    }
}
