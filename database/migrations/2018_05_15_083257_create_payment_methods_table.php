<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\PaymentMethod;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        PaymentMethod::create([ 'name' => 'Credit Card' ]);
        PaymentMethod::create([ 'name' => 'Debit Card' ]);
        PaymentMethod::create([ 'name' => 'Cheque' ]);
        PaymentMethod::create([ 'name' => 'Cash' ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
