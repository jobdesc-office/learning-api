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
        Schema::create('sttbhistory', function (Blueprint $table) {
            $table->id('tbhistoryid');
            $table->string('tbname', 100)->nullable();
            $table->string('tbfield', 100)->nullable();
            $table->string('asfield', 100)->nullable();
            $table->string('calfunc', 100)->nullable();
            $table->text('remarkformat')->nullable();

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
        Schema::dropIfExists('sttbhistory');
    }
}
