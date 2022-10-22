<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('gallery_images')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->longText('description');
            $table->unsignedBigInteger('gallery_album_id');
            $table->foreign('gallery_album_id')->references('id')->on('gallery_albums')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->date('deleted_at')->nullable();
                                    $table->integer('order')->default(0);
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
        Schema::dropIfExists('gallery_images');
    }
}
