<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

            $table->string('title');
            $table->string('slug');
            $table->date('deleted_at')->nullable();
            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('client_categories');
    }
}
