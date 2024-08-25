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
        Schema::create('student_transports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('parent_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('parent_id')->references('id')->on('parents');
            $table->unsignedBigInteger('transport_id');
            $table->foreign('transport_id')->references('id')->on('transports');
            $table->enum('status',['تأخر','غياب','حاضر','إذن']);
            $table->string('note')->nullable();
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_transports');
    }
};
