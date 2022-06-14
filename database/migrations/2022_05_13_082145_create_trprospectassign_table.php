<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrprospectassignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trprospectassign', function (Blueprint $table) {
            $table->id('prospectassignid');
            $table->integer('prospectassignto');
            $table->integer('prospectid');
            $table->integer('prospectreportto');
            $table->text('prospectassigndesc')->nullable();

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
        Schema::dropIfExists('trprospectassign');
    }
}
