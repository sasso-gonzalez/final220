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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('emp_id'); // Foreign key to employees table
            $table->string('caregroup')->nullable(); // Group that caregiver takes per day
            $table->date('shift_date'); // Date of the shift
            $table->timestamp('shift_start');
            $table->timestamp('shift_end');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');

            // Unique constraint to enforce one caregiver per group per date
            $table->unique(['shift_date', 'caregroup', 'emp_id'], 'unique_caregiver_group_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
