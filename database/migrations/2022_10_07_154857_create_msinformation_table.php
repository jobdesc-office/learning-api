<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsinformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msinformation', function (Blueprint $table) {
            $table->id('infoid');
            $table->string('infoname');
            $table->text('infodesc')->nullable(true);

            $table->bigInteger('createdby')->nullable(true);
            $table->timestamp('createddate')->useCurrent();
            $table->bigInteger('updatedby')->nullable(true);
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
        Schema::dropIfExists('msinformation');
    }
}
