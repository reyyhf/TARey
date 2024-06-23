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
        Schema::table('teacher_lessons', function (Blueprint $table) {
            $table->string('classroom_id')->nullable(true);
            $table->string('lesson_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_lessons', function (Blueprint $table) {
            $table->string('lesson_id')->nullable(true)->change();
            $table->dropColumn('classroom_id');
        });
    }
};
