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
            $table->bigInteger('attbpid');
            $table->bigInteger('attuserid');
            $table->date('attdate');
            $table->time('attclockin');
            $table->time('attclockout');
            $table->double('attlat');
            $table->double('attlong');
            $table->text('attaddress');

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
