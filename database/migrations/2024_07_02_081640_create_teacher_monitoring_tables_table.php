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
        Schema::create('teacher_monitoring', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete(); // teacher
            $table->enum('hall',['1','2','3','4','5','6','7','8','9']); // hall
            $table->date('date');// date of monitoring 12/6/2024
            $table->time('start_time'); // from 9:00
            $table->time('end_time');  // t0   11:00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_monitoring_tables');
    }
};
