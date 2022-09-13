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
        pgsql()->create('trhistory', function (Blueprint $table) {
            $table->id('historyid');
            $table->bigInteger('historytbhistoryid')->nullable();
            $table->bigInteger('historyrefid')->nullable();
            $table->text('historyremark')->nullable();
            $table->text('historyoldvalue')->nullable();
            $table->text('historynewvalue')->nullable();
            $table->bigInteger('historybpid')->nullable();
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
        pgsql()->dropIfExists('trhistory');
    }
}
