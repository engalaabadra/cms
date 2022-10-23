<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageAccordionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_accordions', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('page_accordions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('body');
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
        Schema::dropIfExists('page_accordions');
    }
}
