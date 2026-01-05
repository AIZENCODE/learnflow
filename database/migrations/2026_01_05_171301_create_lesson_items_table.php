<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Items de las lecciones
    public function up(): void
    {
        Schema::create('lesson_items', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Título del contenido');
            $table->text('description')->nullable()->comment('Descripción breve');

            $table->integer('order')->default(0)->comment('Orden dentro del módulo');

            // Tipo de contenido (video, artículo, quiz, etc.)
            $table->enum('content_type', [
                'video',
                'article',
                'quiz',
                'assignment',
                'download',
                'external_link',
                'live_session'
            ])->default('video')->comment('Tipo de contenido');

            $table->enum('completion_type', [
                'automatic',     // Se completa automáticamente al terminar video
                'quiz',          // Requiere aprobar quiz
                'manual',        // El usuario marca como completado manualmente
                'text_answer',   // Requiere enviar respuesta de texto
                'file_upload',   // Requiere subir archivo
                'external'       // Completado por sistema externo
            ])->default('automatic')->comment('Tipo de validación de completado');

            // Contenido específico según tipo
            $table->text('content')->nullable()->comment('Contenido HTML/texto');
            $table->text('video_url')->nullable()->comment('URL del video');
            $table->integer('video_duration')->nullable()->comment('Duración en segundos');
            $table->text('external_url')->nullable()->comment('URL externa');
            $table->string('file_path')->nullable()->comment('Ruta de archivo descargable');

            // Configuración
            $table->boolean('is_preview')->default(false)->comment('¿Es vista previa gratuita?');
            $table->boolean('is_published')->default(true)->comment('¿Contenido publicado?');
            $table->boolean('requires_completion')->default(true)->comment('¿Requiere marcar como completado?');

            // Sistema de puntos para ESTE item
            $table->float('xp_points')->default(0)->comment('XP por completar este item');

            // Relación con el módulo/lección
            $table->foreignId('lesson_id')
                ->constrained('lessons')
                ->onDelete('cascade')
                ->comment('Módulo/lección al que pertenece');

            // Relación con quiz si aplica (se puede relacionar directamente con questions)
            // $table->foreignId('quiz_id')->nullable()->comment('Quiz asociado (si content_type=quiz)');

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
        Schema::dropIfExists('lesson_items');
    }
};
