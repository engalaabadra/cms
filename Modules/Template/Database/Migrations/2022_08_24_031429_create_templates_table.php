<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
                        $table->string('locale')->default(config('app.locale'));
             $table->string('main_lang')->default(config('app.locale'));

            $table->string('name');
            $table->string('main_value');
            $table->string('value');
            $table->string('main_model');
            $table->string('model');
            $table->tinyInteger('have_sub')->default(1);
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('templates');
    }
}
