<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSttbhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('sttbhistory', function (Blueprint $table) {
            $table->id('tbhistoryid');
            $table->string('tbhistorytbname', 100)->nullable();
            $table->string('tbhistorytbfield', 100)->nullable();
            $table->string('tbhistoryasfield', 100)->nullable();
            $table->string('tbhistorycallfunc', 100)->nullable();
            $table->text('tbhistoryremarkformat')->nullable();

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
        pgsql()->dropIfExists('sttbhistory');
    }
}
