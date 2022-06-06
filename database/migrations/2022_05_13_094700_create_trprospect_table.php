<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrprospectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trprospect', function (Blueprint $table) {
            $table->id('prospectid');
            $table->text('prospectname');
            $table->date('prospectstartdate')->nullable();
            $table->date('prospectenddate')->nullable();
            $table->double('prospectvalue')->nullable();
            $table->integer('prospectowner');
            $table->integer('prospectstageid');
            $table->integer('prospectstatusid');
            $table->integer('prospecttypeid');
            $table->date('prospectexpclosedate')->nullable();
            $table->integer('prospectbpid');
            $table->text('prospectdescription')->nullable();
            $table->integer('prospectcustid');
            $table->integer('prospectrefid')->nullable();

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
        Schema::dropIfExists('trprospect');
    }
}
