<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVtscheduleguestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtscheduleguest', function (Blueprint $table) {
            $table->id('scheguestid');
            $table->integer('scheid')->nullable();
            $table->integer('scheuserid')->nullable();
            $table->integer('schebpid')->nullable();
            
            $table->bigInteger('createdby')->nullable();
            $table->timestamp('createddate')->useCurrent();
            $table->bigInteger('updatedby')->nullable();
            $table->timestamp('updateddate')->useCurrent();
            $table->boolean('isactive')->default(true);
        });
        DB::statement('ALTER TABLE vtscheduleguest ADD COLUMN schepermisid character varying[] null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vtscheduleguest');
    }
}
