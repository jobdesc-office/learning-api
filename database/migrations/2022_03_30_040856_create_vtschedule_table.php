<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtscheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('vtschedule', function (Blueprint $table) {
            $table->id('scheid');
            $table->string('schecd', 100)->nullable();
            $table->string('schenm', 50)->nullable();
            $table->date('schestartdate')->nullable();
            $table->date('scheenddate')->nullable();
            $table->time('schestarttime')->nullable();
            $table->time('scheendtime')->nullable();
            $table->integer('schetypeid')->nullable();
            $table->date('scheactdate')->nullable();
            $table->integer('schetowardid')->nullable();
            $table->integer('schebpid')->nullable();
            $table->integer('schereftypeid')->nullable();
            $table->integer('scherefid')->nullable();
            $table->boolean('scheallday')->nullable();
            $table->text('scheloc')->nullable();
            $table->boolean('scheprivate')->nullable();
            $table->boolean('scheonline')->nullable();
            $table->text('schetz')->nullable();
            $table->integer('scheremind')->nullable();
            $table->text('schedesc')->nullable();
            $table->text('scheonlink')->nullable();

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
        pgsql()->dropIfExists('vtschedule');
    }
}
