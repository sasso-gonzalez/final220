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
        Schema::create('patient_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->unsignedBigInteger('patient_id'); // Foreign key to patient table
            $table->unsignedBigInteger('caregiver_id'); // Foreign key to employee table
            $table->date('particular_date')->nullable();
            $table->boolean('m_med')->default(false);
            $table->boolean('a_med')->default(false);
            $table->boolean('n_med')->default(false);
            $table->boolean('breakfast')->default(false);
            $table->boolean('lunch')->default(false);
            $table->boolean('dinner')->default(false);
            $table->timestamps();

            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreign('caregiver_id')->references('emp_id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_schedules');
    }
};
