<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsuserdtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msuserdt', function (Blueprint $table) {
            $table->id('userdtid');
            $table->bigInteger('userid');
            $table->bigInteger('userdttypeid');
            $table->bigInteger('userdtbpid');
            $table->string('userdtbranchnm', 100)->nullable();
            $table->string('userdtreferalcode', 50)->nullable();
            $table->bigInteger('userdtrelationid')->nullable();

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
        Schema::dropIfExists('msuserdt');
    }
}
