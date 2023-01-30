<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        pgsql()->create('msuser', function (Blueprint $table) {
            $table->id('userid');
            $table->string('username', 50);
            $table->string('usercode', 50)->nullable();
            $table->text('userpassword');
            $table->string('userfullname', 100);
            $table->string('useremail', 100)->nullable();
            $table->string('userphone', 100)->nullable();
            $table->string('userdeviceid', 50)->nullable();
            $table->text('userfcmtoken')->nullable();
            $table->bigInteger('userappaccess')->nullable();
            $table->text('usersocketid')->nullable();

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
        pgsql()->dropIfExists('msuser');
    }
}
