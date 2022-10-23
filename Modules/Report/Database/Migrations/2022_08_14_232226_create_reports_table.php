<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('reports')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->longText('description');
            $table->unsignedBigInteger('report_category_id');
            $table->foreign('report_category_id')->references('id')->on('report_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->date('date');
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
        Schema::dropIfExists('reports');
    }
}
