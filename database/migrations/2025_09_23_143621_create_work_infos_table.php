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
        Schema::create('work_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            // 3.1 Current Occupation
            $table->enum('occupation', [
                'Businessperson',
                'Company employee',
                'Entertainer',
                'Industrial/agricultural worker',
                'Student',
                'Member of parliament',
                'Government official',
                'Teacher',
                'Researcher',
                'Medical professional',
                'Engineer/Technician',
                'Self-employed',
                'Unemployed',
                'Retired',
                'Other'
            ]);

            // 3.2 Work Experience in the past five years
            $table->date('work_exp_date_from')->nullable();
            $table->date('work_exp_date_to')->nullable();

            // Employer
            $table->string('employer_name')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('employer_telephone')->nullable();

            // Supervisor
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_telephone')->nullable();

            // Position & Duty
            $table->string('position_name')->nullable();
            $table->string('duty_name')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_infos');
    }
};
