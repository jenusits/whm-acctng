<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('request_funds', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('author');
        //     $table->integer('approved')->default(0);
        //     $table->integer('approved_by')->nullable();
        //     $table->dateTime('approved_on')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_funds');
    }
}
