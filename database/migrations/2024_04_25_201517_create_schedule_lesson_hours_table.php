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
        Schema::create('schedule_lesson_hours', function (Blueprint $table) {
            $table->string('id')
                ->primary()
                ->index();

            $table->string('schedule_day_id')->index();

            $table->integer('started_at');
            $table->integer('ended_at');
            $table->string('started_duration');
            $table->string('ended_duration');

            $table->integer('order_direction')->default(1);
            $table->boolean('is_break_hour')->default(false);

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
        Schema::dropIfExists('schedule_lesson_hours');
    }
};
