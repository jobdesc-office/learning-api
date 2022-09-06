<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStbptypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stbptype', function (Blueprint $table) {
            $table->id('sbtid');
            $table->bigInteger('sbtbpid');
            $table->text('sbtname')->nullable();
            $table->integer('sbtseq')->nullable();
            $table->bigInteger('sbttypemasterid');
            $table->text('sbttypename')->nullable();

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
        Schema::dropIfExists('stbptype');
    }
}
