<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
                        $table->string('locale')->default(config('app.locale'));
                                     $table->string('main_lang')->default(config('app.locale'));

            $table->string('session_id');
            $table->string('word');
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
        Schema::dropIfExists('searches');
    }
}
