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
        Schema::create('family_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            // 5.1 Current home address
            $table->string('current_home_address');

            // 5.2 Phone Number
            $table->string('home_phone_number')->nullable();

            // 5.3 Mobile Phone Number
            $table->string('home_mobile_number');

            // 5.4 Email
            $table->string('home_email')->nullable();

            // ---------- Father ----------
            $table->string('father_family_name');
            $table->string('father_givenname');
            $table->unsignedBigInteger('father_nationality_id'); // FK from countries
            $table->date('father_dob');
            $table->boolean('father_siberia_origin')->default(false);

            // ---------- Mother ----------
            $table->string('mother_family_name');
            $table->string('mother_givenname');
            $table->unsignedBigInteger('mother_nationality_id'); // FK from countries
            $table->date('mother_dob');
            $table->boolean('mother_siberia_origin')->default(false);

            // ---------- Children (assuming one child entry here) ----------
            $table->string('children_family_name')->nullable();
            $table->string('children_givenname')->nullable();
            $table->unsignedBigInteger('children_nationality_id')->nullable(); // FK from countries
            $table->date('children_dob')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
            $table->foreign('father_nationality_id')->references('id')->on('countries');
            $table->foreign('mother_nationality_id')->references('id')->on('countries');
            $table->foreign('children_nationality_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_infos');
    }
};
