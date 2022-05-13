<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrprospectproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trprospectproduct', function (Blueprint $table) {
            $table->id('prospectproductid');
            $table->integer('prospectid');
            $table->double('prospectproductprice')->nullable();
            $table->integer('prospectqty')->nullable();
            $table->double('prospecttax')->nullable();
            $table->double('prospectdiscount')->nullable();
            $table->double('prospectamount')->nullable();
            $table->integer('prospecttaxtypeid');

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
        Schema::dropIfExists('trprospectproduct');
    }
}
