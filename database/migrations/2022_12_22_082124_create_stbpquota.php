<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStbpquota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('stbpquota', function (Blueprint $table) {
            $table->id('sbqid');
            $table->bigInteger('sbqbpid');
            $table->bigInteger('sbqwebuserquota')->default(0);
            $table->bigInteger('sbqmobuserquota')->default(0);
            $table->bigInteger('sbqcstmquota')->default(0);
            $table->bigInteger('sbqcntcquota')->default(0);
            $table->bigInteger('sbqprodquota')->default(0);
            $table->bigInteger('sbqprosquota')->default(0);
            $table->bigInteger('sbqdayactquota')->default(0);
            $table->bigInteger('sbqprosactquota')->default(0);

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
        pgsql()->dropIfExists('stbpquota');
    }
}
