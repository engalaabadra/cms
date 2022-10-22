<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->longText('body');
            $table->longText('description');
            $table->longText('meta_description');
            $table->longText('meta_keywords');
            $table->string('link');

            $table->unsignedBigInteger('project_category_id');
            $table->foreign('project_category_id')->references('id')->on('project_categories')->onUpdate('cascade')->onDelete('cascade');
          
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
        Schema::dropIfExists('projects');
    }
}
