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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            // Other country visas (multi slot)
            $table->string('other_country_visa1');
            $table->string('other_country_visa2')->nullable();
            $table->string('other_country_visa3')->nullable();
            $table->string('other_country_visa4')->nullable();
            $table->string('other_country_visa5')->nullable();
            $table->string('other_country_visa6')->nullable();

            // Itinerary
            $table->string('itinerary_siberia');

            // Hotel requirement
            $table->string('hote_requirement');

            // Bank statements (multi slot)
            $table->string('bank_statement1');
            $table->string('bank_statement2')->nullable();
            $table->string('bank_statement3')->nullable();
            $table->string('bank_statement4')->nullable();

            // Air ticket
            $table->string('air_ticket');

            // Invitation letter
            $table->string('invitation_letter');

            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
