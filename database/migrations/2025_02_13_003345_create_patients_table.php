<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string(column: 'middle_name')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Divorced', 'Widowed'])->default('Single');
            $table->string('contact_number', 15)->nullable();
            $table->string('image')->nullable();
            $table->string('street')->nullable();
            $table->string('brgy')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('ec_name')->nullable();
            $table->string('ec_address')->nullable();
            $table->string('ec_contact', 15)->nullable();
            $table->enum('ec_relation', ['Spouse', 'Parent', 'Sibling', 'Child', 'Grandparent', 'Aunt', 'Uncle', 'Nephew', 'Niece'])->default('Parent');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
