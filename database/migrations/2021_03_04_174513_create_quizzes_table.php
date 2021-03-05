<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schoolclass_id')->constrained('schoolclasses');
            $table->foreignId('subjectmatter_id')->constrained();
            $table->foreignId('teacher_id')->nullable()->constrained();
            $table->foreignId('admin_id')->nullable()->constrained();
            $table->string('title');
            $table->text('instructions')->nullable();
            $table->integer('point')->nullable();
            $table->date('due');
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
        Schema::dropIfExists('quizzes');
    }
}
