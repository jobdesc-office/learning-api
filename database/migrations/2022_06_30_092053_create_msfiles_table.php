<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('msfiles', function (Blueprint $table) {
            $table->id('fileid');
            $table->bigInteger('transtypeid');
            $table->bigInteger('refid');
            $table->text('directories');
            $table->string('filename', 100);
            $table->string('mimetype', 100);
            $table->double('filesize');
            $table->text('remark')->nullable();

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
        pgsql()->dropIfExists('msfiles');
    }
}
