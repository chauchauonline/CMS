<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFunds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type');
            $table->text('content');
            $table->timestamp('date')->nullable();
            $table->double('amount', 15, 0);
            $table->softDeletes();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fund');
    }
}
