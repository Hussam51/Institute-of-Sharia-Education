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
        Schema::create('week_tables', function (Blueprint $table) {
            $table->id();
            $table->enum('term',['1','2']);
            $table->foreignId('subject_id')->constrained('subjects','id')->cascadeOnDelete();
            $table->enum('day',['sunday','monday','tuesday','wednesday','thursday']);// sunday , monday ...thursday. اليوم: مثل
            $table->enum('session',['1','2','3','4','5','6','7']); // الحصة
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
        Schema::dropIfExists('week_tables');
    }
};
