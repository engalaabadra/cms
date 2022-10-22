<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default(config('app.locale'));
                         $table->string('main_lang')->default(config('app.locale'));

             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('staffs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('staff_category_id');
            $table->foreign('staff_category_id')->references('id')->on('staff_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('job');
            $table->longText('description');
            $table->longText('body');
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
        Schema::dropIfExists('staffs');
    }
}
