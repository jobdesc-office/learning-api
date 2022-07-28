<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtchatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtchat', function (Blueprint $table) {
            $table->id('chatid');
            $table->bigInteger('chatbpid');
            $table->text('chatmessage')->nullable();
            $table->string('chatrefname', 255)->nullable();
            $table->bigInteger('chatrefid')->nullable();
            $table->text('chatfile')->nullable();
            $table->timestamp('chatreadat')->nullable();
            $table->bigInteger('chatreceiverid')->nullable();

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
        Schema::dropIfExists('vtchat');
    }
}
