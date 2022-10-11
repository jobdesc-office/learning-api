<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVtoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('vtoption', function (Blueprint $table) {
            $table->id('optid');
            $table->bigInteger('cusftid');
            $table->text('optvalue');

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
        pgsql()->dropIfExists('vtoption');
    }
}
