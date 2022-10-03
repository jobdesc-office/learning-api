<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->bigInteger('attbpid')->nullable(true);
            $table->bigInteger('attuserid')->nullable(true);
            $table->date('attdate')->nullable(true);
            $table->time('attclockin')->nullable(true);
            $table->time('attclockout')->nullable(true);
            $table->double('attlat')->nullable(true);
            $table->double('attlong')->nullable(true);
            $table->text('attaddress')->nullable(true);

            $table->bigInteger('createdby')->nullable(true);
            $table->timestamp('createddate')->useCurrent();
            $table->bigInteger('updatedby')->nullable(true);
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
