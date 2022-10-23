<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('pages')->onUpdate('CASCADE')->onDelete('CASCADE');
                      $table->string('page_url');
            $table->string('title');
            $table->longText('body');
            $table->longText('meta_description');
            $table->longText('meta_keywords');
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('static')->default(0);//dynamic
            $table->tinyInteger('with_slider')->default(1);
            $table->tinyInteger('with_side')->default(0);
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
        Schema::dropIfExists('pages');
    }
}
