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
        Schema::create('teacher_week_times', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('subject_id')->constrained('subjects','id')->cascadeOnDelete();
            $table->enum('day',['sunday','monday','tuesday','wednesday','thursday']);// sunday , monday ...thursday. اليوم: مثل
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_week_tables');
    }
};
