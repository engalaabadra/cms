   <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->default(config('app.locale'));
             $table->unsignedBigInteger('translate_id')->nullable();
            $table->foreign('translate_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
           
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
