<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
                        $table->string('locale')->default(config('app.locale'));
                                     $table->string('main_lang')->default(config('app.locale'));

            $table->string('title');
            $table->longText('description');
            $table->string('video_link');
            $table->unsignedBigInteger('video_category_id');
            $table->foreign('video_category_id')->references('id')->on('video_categories')->onUpdate('cascade')->onDelete('cascade');
            
                        $table->tinyInteger('published')->default(1);
                        $table->tinyInteger('is_featured')->default(1);
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
        Schema::dropIfExists('videos');
    }
}
