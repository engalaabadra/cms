<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageBannerPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_banner_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_banner_id')->nullable();
            $table->foreign('page_banner_id')
                ->references('id')
                ->on('page_banners')
                ->onDelete('cascade');
            $table->string('filename');
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
        Schema::dropIfExists('page_banner_photos');
    }
}
