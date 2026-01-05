<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Cursos
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Título del curso');
            $table->string('slug')->unique()->comment('Slug para URL amigable');
            $table->text('description')->nullable()->comment('Descripción completa del curso');

            // Multimedia - ¿Qué mostrar?
            $table->enum('show_media_type', ['image', 'video', 'none'])
                  ->default('image')
                  ->comment('Tipo de media a mostrar (imagen o video)');

            // Campos de multimedia

            $table->string('icon_path')->nullable()->comment('Ruta de la icono del curso');
            $table->string('image_path')->nullable()->comment('Ruta de la imagen del curso');
            $table->string('video_path')->nullable()->comment('Ruta del video promocional');
            $table->boolean('is_external_link')->default(false)
                  ->comment('¿Es solo un enlace a curso externo?');

            // Información básica
            $table->text('short_description')->nullable()->comment('Descripción breve del curso');
            $table->integer('duration_minutes')->nullable()->comment('Duración en minutos');
            $table->decimal('price', 8, 2)->default(0.00)->comment('Precio');
            $table->boolean('is_free')->default(false)->comment('¿Gratuito?');
            $table->boolean('is_published')->default(false)->comment('¿Publicado?');

            // Orden y XP
            $table->integer('order_in_track')->nullable()->comment('Orden en la ruta');
            $table->float('xp_points')->default(0)->comment('Puntos de experiencia');

            // Relaciones
            $table->foreignId('track_id')
                  ->nullable()
                  ->constrained('tracks')
                  ->onDelete('set null')
                  ->comment('Ruta asociada');

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
        Schema::dropIfExists('courses');
    }
};
