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
        Schema::create('education_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            $table->string('institute_name');
            $table->enum('degree_name', [
                'Technical secondary school/high school or equivalent',
                'Junior college/undergraduate degree or equivalent', 
                'Masters degree or equivalent',
                'Doctoral degree or above',
                'Other'
            ])->default('Other');

            $table->string('major_degree')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_infos');
    }
};
