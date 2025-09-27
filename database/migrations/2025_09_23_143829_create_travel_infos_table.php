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
        Schema::create('travel_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            // 6.1 Visa Category
            $table->enum('visa_category', ['tourist', 'business', 'work']);

            // 6.1B & 6.1C Hotel info (tourist/business)
            $table->string('hotel_name')->nullable();
            $table->string('hotel_address')->nullable();

            // 6.1D Work (Company Approval Letter file path)
            $table->string('company_approval_letter')->nullable();

            // 6.2 Inviting Person / Organization in Siberia
            $table->string('inviting_name');
            $table->string('inviting_relationship');
            $table->string('inviting_phone_number');
            $table->string('inviting_email')->nullable();
            $table->string('inviting_city');
            $table->string('inviting_district')->nullable();
            $table->string('inviting_post_code')->nullable();

            // 6.3 Emergency Contact
            $table->string('emergency_contact_family_name');
            $table->string('emergency_contact_givenname');
            $table->string('emergency_contact_relationship');
            $table->string('emergency_contact_phone_number');
            $table->string('emergency_contact_email')->nullable();

            // 6.4 Who will pay for this travel
            $table->enum('travel_payer', ['self', 'other', 'organization']);

            // 6.5 Same passport
            $table->boolean('same_passport')->default(false);

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_infos');
    }
};
