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
        Schema::create('other_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('application_id');
            $table->enum('refused_visa', ['yes', 'no'])->nullable();
            $table->enum('visa_canceled', ['yes', 'no'])->nullable();
            $table->enum('illegal_entry', ['yes', 'no'])->nullable();
            $table->enum('criminal_record', ['yes', 'no'])->nullable();
            $table->enum('health_issue', ['yes', 'no'])->nullable();
            $table->enum('epidemic_visit', ['yes', 'no'])->nullable();
            $table->enum('special_skill', ['yes', 'no'])->nullable();
            $table->enum('military_service', ['yes', 'no'])->nullable();
            $table->enum('paramilitary', ['yes', 'no'])->nullable();
            $table->enum('organization_work', ['yes', 'no'])->nullable();
            $table->enum('other_declaration', ['yes', 'no'])->nullable();

            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_infos');
    }
};
