<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rfindex')->nullable();
            $table->integer('expenses_id');
            $table->text('particulars');
            $table->bigInteger('amount');
            $table->integer('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_metas');
    }
}
