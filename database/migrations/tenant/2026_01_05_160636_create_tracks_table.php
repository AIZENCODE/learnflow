<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Rutas
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Nombre de la ruta de aprendizaje');
            $table->text('description')->nullable()->comment('Descripción de la ruta');
            $table->integer('order')->default(0)->comment('Orden de visualización');

            $table->string('image_path')->nullable()->comment('Ruta de la imagen de la ruta');
            $table->string('background_path')->nullable()->comment('Ruta de la imagen de fondo de la ruta');
            $table->string('video_path')->nullable()->comment('Ruta del video de la ruta');
            $table->string('icon_path')->nullable()->comment('Ruta del icono de la ruta');

            $table->float('xp_points')->default(0)->comment('Puntos de experiencia (XP)');


            // SISTEMA DE TIEMPO LIMITADO
            $table->boolean('has_time_limit')->default(false)->comment('¿Tiene tiempo límite?');
            $table->date('start_date')->nullable()->comment('Fecha de inicio del período');
            $table->date('end_date')->nullable()->comment('Fecha de finalización del período');
            $table->enum('time_limit_type', ['from_enrollment', 'fixed_date', 'self_paced'])
                ->default('self_paced')
                ->comment('Tipo de límite de tiempo');



            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->comment('Usuario que creó la ruta');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->comment('Usuario que actualizó por última vez');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
