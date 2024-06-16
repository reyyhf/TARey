<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('id')
                ->primary()
                ->index();

            $table->string('user_id')->index();
            $table->string('role_id')->index();
            $table->string('user_status_id')->index();

            $table->string('nuptk')->unique();
            $table->string('name');
            $table->boolean('gender');
            $table->string('birth_place');
            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
