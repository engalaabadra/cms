<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
                        $table->string('locale')->default(config('app.locale'));
                                     $table->string('main_lang')->default(config('app.locale'));

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->date('transfer_date');
            $table->string('name_doctor');
            $table->string('specialization');
            $table->string('phone_no_doctor');
            $table->string('institution_made_transfer');
            $table->string('phone_no_institution');
            $table->string('name_patient');
            $table->date('birth_date');
            $table->string('sex');
            $table->string('name_parent');
            $table->string('phone_no_patient');
            $table->longText('reason_conversion');
            $table->string('symptoms_seen');
            $table->string('presumed_diagnosis');
            $table->longText('health_problems');
            $table->longText('patient_taking_medication');
            $table->tinyInteger('suggested_services');
            $table->date('date');
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
        Schema::dropIfExists('forms');
    }
}
