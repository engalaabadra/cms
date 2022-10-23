<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
                        $table->string('locale')->default(config('app.locale'));
             $table->string('main_lang')->default(config('app.locale'));

            $table->string('name');
            $table->string('region');
            $table->string('phone_no');
            $table->string('email');
            $table->longText('subject');
            $table->longText('body');
                        $table->tinyInteger('is_robot');
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
        Schema::dropIfExists('contact_us');
    }
}
