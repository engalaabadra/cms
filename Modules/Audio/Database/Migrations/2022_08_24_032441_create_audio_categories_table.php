<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

                         $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('audio_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->string('slug');
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
        Schema::dropIfExists('audio_categories');
    }
}
