<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtcustomfieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtcustomfield', function (Blueprint $table) {
            $table->id('custfid');
            $table->bigInteger('custfbpid');
            $table->string('custfname', 255);
            $table->bigInteger('custftypeid');
            $table->boolean('isvisiblesidebar')->default(false);
            $table->boolean('onlyinnewprospect')->default(false);

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
        Schema::dropIfExists('vtcustomfield');
    }
}
