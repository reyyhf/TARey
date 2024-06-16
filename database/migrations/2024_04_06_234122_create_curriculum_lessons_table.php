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
        Schema::create('curriculum_lessons', function (Blueprint $table) {
            $table->string('semester_id')->index();
            $table->string('lesson_id')->index();
            $table->string('classroom_id')->index();
            $table->integer('maximum_hours_per_week')->default(0);
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
        Schema::dropIfExists('curriculum_lessons');
    }
};
