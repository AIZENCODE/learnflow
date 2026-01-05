<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Inscripciones
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->comment('Usuario inscrito');

            $table->foreignId('track_id')
                ->nullable()
                ->constrained('tracks')
                ->comment('Ruta en la que está inscrito');

            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->comment('Curso en el que está inscrito');

            $table->enum('status', ['pending', 'active', 'paused', 'completed', 'cancelled'])
                ->default('active')
                ->comment('Estado de la inscripción');

            $table->timestamp('enrolled_at')->comment('Fecha de inscripción');
            $table->timestamp('completed_at')->nullable()->comment('Fecha de completación');
            $table->timestamp('expires_at')->nullable()->comment('Fecha de expiración');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
