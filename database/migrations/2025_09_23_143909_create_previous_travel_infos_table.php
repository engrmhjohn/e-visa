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
        Schema::create('previous_travel_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            // 7.1 - Have you ever been to Siberia?
            $table->enum('travel_siberia', ['yes', 'no'])->nullable();

            // 7.2 - Have you ever gotten a Chinese visa?
            $table->enum('previous_siberia_visa', ['yes', 'no'])->nullable();

            // 7.3 - Do you have any valid visa issued by other countries?
            $table->enum('other_country_visa', ['yes', 'no'])->nullable();

            // 7.4 - Have you visited any countries in the last 12 months?
            $table->enum('visited_last_12_months', ['yes', 'no'])->nullable();

            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_travel_infos');
    }
};
