<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtcompetitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtcompetitor', function (Blueprint $table) {
            $table->id('comptid');
            $table->bigInteger('comptbpid')->nullable();
            $table->bigInteger('comptreftypeid')->nullable();
            $table->bigInteger('comptrefid')->nullable();
            $table->text('comptname')->nullable();
            $table->text('comptproductname')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('vtcompetitor');
    }
}
