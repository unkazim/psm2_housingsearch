<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id('property_id');
            $table->foreignId('landlord_id')->constrained('landlords', 'landlord_id')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('address');
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('distance_from_uthm', 5, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->date('listed_date');
            $table->enum('status', ['available', 'rented', 'pending']);
            $table->enum('preferred_gender', ['any', 'male', 'female']);
            $table->enum('property_type', ['whole house', 'room']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};