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
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            // Uploads
            $table->string('picture'); // profile image path
            $table->string('passport_picture'); // passport data page image path

            // 1.1 Name
            $table->string('family_name'); // required
            $table->string('given_names'); // required
            $table->string('other_names')->nullable();
            $table->string('siberia_name')->nullable();

            // 1.2 Date of birth
            $table->date('dob'); // required

            // 1.3 Gender
            $table->enum('gender', ['male', 'female']); // required

            // 1.4 Place of birth
            $table->unsignedBigInteger('birth_country_id');  // required
            $table->string('province_state'); // required
            $table->string('city'); // required

            // 1.5 Marital status
            $table->enum('marital_status', ['married', 'divorced', 'single', 'widowed', 'others']); // required

            // 1.6 Nationality and permanent residence
            $table->unsignedBigInteger('current_nationality_id');  // required
            $table->string('id_number'); // required
            $table->enum('other_nationality', ['yes', 'no'])->default('no'); // required
            $table->enum('permanent_resident_status', ['yes', 'no'])->default('no'); // required
            $table->enum('previous_nationalities', ['yes', 'no'])->default('no'); // required

            // 1.7 Passport information
            $table->enum('passport_type', ['ordinary', 'service', 'diplomatic', 'official', 'special', 'others']); // required
            $table->string('passport_number'); // required
            $table->unsignedBigInteger('issuing_country_id');  // required
            $table->string('place_of_issue'); // required
            $table->date('passport_expiration_date'); // required

            $table->timestamps();
            $table->foreign('birth_country_id')->references('id')->on('countries');
            $table->foreign('current_nationality_id')->references('id')->on('countries');
            $table->foreign('issuing_country_id')->references('id')->on('countries');
            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_infos');
    }
};
