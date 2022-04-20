<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStbpcustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stbpcustomer', function (Blueprint $table) {
            $table->id('bpcustomerid');
            $table->bigInteger('bpid');
            $table->bigInteger('customerid');
            $table->string('customername', 100);
            $table->string('customerphone', 255)->nullable();
            $table->string('customeraddress', 255)->nullable();
            $table->string('customerpic', 255)->nullable();

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
        Schema::dropIfExists('stbpcustomer');
    }
}
