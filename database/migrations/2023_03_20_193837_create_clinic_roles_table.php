<?php

use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clinic_roles', function (Blueprint $table) {
            $table->id();
            $table->ulid()->unique();

            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('specialty_id')->constrained('doctor_specialties');
            $table->foreignId('clinic_id')->constrained('clinics');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_roles');
    }
};
