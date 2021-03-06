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
            $table->id('prosproductid');
            $table->integer('prosproductprospectid');
            $table->integer('prosproductproductid');
            $table->double('prosproductprice')->nullable();
            $table->integer('prosproductqty')->nullable();
            $table->double('prosproducttax')->nullable();
            $table->double('prosproductdiscount')->nullable();
            $table->double('prosproductamount')->nullable();
            $table->integer('prosproducttaxtypeid')->nullable();

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
