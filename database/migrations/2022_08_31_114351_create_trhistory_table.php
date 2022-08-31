<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trhistory', function (Blueprint $table) {
            $table->id('historyid');
            $table->bigInteger('tbhistoryid')->nullable();
            $table->bigInteger('refid')->nullable();
            $table->text('remark')->nullable();
            $table->text('oldvalue')->nullable();
            $table->text('newvalue')->nullable();
            $table->bigInteger('bpid')->nullable();
            $table->string('historysource', 100)->nullable();

            $table->bigInteger('createdby')->nullable();
            $table->timestamp('createddate')->useCurrent();
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
        Schema::dropIfExists('trhistory');
    }
}
