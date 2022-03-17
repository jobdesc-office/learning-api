<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msmenu', function (Blueprint $table) {
            $table->id('menuid');
            $table->bigInteger('masterid')->nullable();
            $table->bigInteger('menutypeid');
            $table->string('menunm', 100);
            $table->string('icon', 100)->nullable();
            $table->string('route', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->integer('seq')->nullable();

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
        Schema::dropIfExists('msmenu');
    }
}
