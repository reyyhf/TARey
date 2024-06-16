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
        Schema::table('curriculum_lessons', function (Blueprint $table) {
            $table->dropIndex(['classroom_id']);
            $table->dropColumn('classroom_id');
            $table->string('id')->after('maximum_hours_per_week')->index();
            $table->string('classroom_label')->after('lesson_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_lessons', function (Blueprint $table) {
            $table->string('classroom_id')->index();
            $table->dropIndex(['classroom_label']);
            $table->dropIndex(['id']);
            $table->dropColumn('id');
            $table->dropColumn('classroom_label');
        });
    }
};
