<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrprospectdtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trprospectdt', function (Blueprint $table) {
            $table->id('prospectdtid');
            $table->integer('prospectdtprospectid');
            $table->integer('prospectdtcatid');
            $table->integer('prospectdttypeid');
            $table->date('prospectdtdate')->nullable();
            $table->text('prospectdtdesc')->nullable();

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
        Schema::dropIfExists('trprospectdt');
    }
}
