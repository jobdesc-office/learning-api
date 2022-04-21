<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMscustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mscustomer', function (Blueprint $table) {
            $table->id('customerid');
            $table->string('customerprefix', 100)->nullable();
            $table->string('customername', 100);
            $table->string('customerphone', 20)->nullable();
            $table->text('customeraddress')->nullable();
            $table->bigInteger('customertypeid')->nullable();
            $table->bigInteger('customerproviceid')->nullable();
            $table->bigInteger('customercityid')->nullable();
            $table->bigInteger('customersubdistrictid')->nullable();
            $table->bigInteger('customeruvid')->nullable();
            $table->string('customerpostalcode', 5)->nullable();
            $table->double('customerlatitude')->nullable();
            $table->double('customerlongitude')->nullable();
            $table->string('referalcode', 255)->nullable();

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
        Schema::dropIfExists('mscustomer');
    }
}
