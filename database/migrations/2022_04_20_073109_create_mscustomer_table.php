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
            $table->id('cstmid');
            $table->string('cstmprefix', 100)->nullable();
            $table->string('cstmname', 100);
            $table->string('cstmphone', 20)->nullable();
            $table->text('cstmaddress')->nullable();
            $table->bigInteger('cstmtypeid')->nullable();
            $table->bigInteger('cstmprovinceid')->nullable();
            $table->bigInteger('cstmcityid')->nullable();
            $table->bigInteger('cstmsubdistrictid')->nullable();
            $table->bigInteger('cstmuvid')->nullable();
            $table->string('cstmpostalcode', 5)->nullable();
            $table->double('cstmlatitude')->nullable();
            $table->double('cstmlongitude')->nullable();
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
