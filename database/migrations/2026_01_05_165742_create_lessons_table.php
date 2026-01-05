<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Lecciones
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Título del módulo');
            $table->string('slug')->nullable()->comment('Slug para URL');
            $table->text('description')->nullable()->comment('Descripción del módulo');

            $table->integer('order')->default(0)->comment('Orden dentro del curso');
            $table->boolean('is_published')->default(true)->comment('¿Módulo publicado?');

            // Relación con curso
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade')
                ->comment('Curso al que pertenece');

            // Sistema de puntos para completar TODO el módulo
            $table->float('xp_points')->default(0)->comment('XP por completar módulo');

            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->comment('Creador');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->comment('Actualizador');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
