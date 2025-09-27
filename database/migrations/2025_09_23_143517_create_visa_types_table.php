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
        Schema::create('visa_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            // 2.1 Type of visa & main purpose
            $table->enum('visa_type', [
                'Tourism', 'Business', 'Work Permit', 'Temporary Work'
            ]); // required

            // Extra Tourist Type
            $table->enum('tourist_type', [
                'tourist', 'business', 'work_permit'
            ])->nullable();

            // 2.2 Service type
            $table->enum('service_type', ['individual', 'group']); // required

            // 2.3 Visa Application Info
            $table->integer('visa_validity'); // months
            $table->integer('max_duration_stay'); // days
            $table->enum('entries', ['single', 'multiple', 'work_permit']); // required

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_types');
    }
};
