<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDspbycustlabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // pgsql()->create('dspbycustlabel', function (Blueprint $table) {
        //     $table->bigInteger('prospectbpid');
        //     $table->string('prospectbpname', 100);
        //     $table->text('prospectcustlabel');
        //     $table->decimal('prospectyy', 8, 2);
        //     $table->decimal('prospectmm', 8, 2);
        //     $table->double('prospectvalue');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dspbycustlabel');
    }
}
