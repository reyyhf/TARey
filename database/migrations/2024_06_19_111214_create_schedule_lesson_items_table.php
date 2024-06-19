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
        Schema::create('schedule_lesson_items', function (Blueprint $table) {
            $table->string('id')->primary()->index();
            $table->string('lesson_id')->index();
            $table->string('teacher_id')->index();
            $table->string('schedule_lesson_id')->index();
            $table->string('schedule_lesson_hour_id')->index();
            $table->softDeletes();
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
        Schema::dropIfExists('schedule_lesson_items');
    }
};
