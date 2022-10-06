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
        pgsql()->create('stbpcustomer', function (Blueprint $table) {
            $table->id('sbcid');
            $table->bigInteger('sbcbpid');
            $table->bigInteger('sbccstmid');
            $table->bigInteger('sbccstmstatusid');
            $table->bigInteger('sbcactivitytypeid');
            $table->string('sbccstmname', 100);
            $table->string('sbccstmphone', 255)->nullable();
            $table->string('sbccstmaddress', 255)->nullable();

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
        pgsql()->dropIfExists('stbpcustomer');
    }
}
