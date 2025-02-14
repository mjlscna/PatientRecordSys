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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departments_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('professions_id')->constrained('professions')->cascadeOnDelete();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string(column: 'middle_name')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('civil_status', ['single', 'married', 'seperated', 'divorce', 'widowed'])->default('single');
            $table->string('image')->nullable();
            $table->string('street')->nullable();
            $table->string('brgy')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
