<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_constraints', function (Blueprint $table) {
            $table->string('id')->primary()->index();
            $table->text("constraint")->nullable();
            $table->enum("type", ["hard", "soft"]);
            $table->boolean('is_dynamic')->default(false);
            $table->integer("max_teaching_hours")->nullable();
            $table->integer("max_subject_hours")->nullable();
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
        Schema::dropIfExists('criteria_constraints');
    }
};
