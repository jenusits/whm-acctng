<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('key', 999);
            $table->text('value')->nullable();
            $table->string('data_type')->nullable();
            $table->boolean('show')->default(false);

            $table->timestamps();
        });

        
        \App\Services\SettingsModule::set('logo', '', 'image', true);
        \App\Services\SettingsModule::set('company_name', '', 'text', true);
        \App\Services\SettingsModule::set('email_address', '', 'text', true);
        \App\Services\SettingsModule::set('currency', '', 'text', true);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
