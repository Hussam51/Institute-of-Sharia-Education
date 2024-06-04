<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->enum('term',['1','2']);
            $table->foreignId('subject_id')->constrained('subjects','id')->cascadeOnDelete();
            $table->dateTime('exam_date'); // 9:30 تاريخ بدء الامتحان باليوم والساعة والدقائق مثل : 2024-7-7 
            $table->integer('exam_duration');// عدد الدقائق مثل: 60دقيقة 
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
