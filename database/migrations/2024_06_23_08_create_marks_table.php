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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            $table->float('student_mark')->default(0.0);
            $table->bigInteger('quiz_id')->unsigned();
            $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();
            
           // $table->bigInteger('subject_id')->unsigned();
           // $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
           // $table->float('min_mark')->default(0.0);
           // $table->float('max_mark')->default(0.0);
           // $table->enum('type',['probe_1','quiz_1','midterm_exam','probe_2','quiz_2','final_exam']);
          
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
        Schema::dropIfExists('marks');
    }
};
