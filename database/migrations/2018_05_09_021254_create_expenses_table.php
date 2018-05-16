<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author');
            $table->integer('bank_credit_account');
            $table->dateTime('payment_date');
            $table->integer('payment_method');
            $table->text('memo')->nullable();
            $table->text('attachment')->nullable();
            $table->integer('approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_on')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
