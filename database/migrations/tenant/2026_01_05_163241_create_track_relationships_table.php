<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Relacion de Rutas con cursos
    public function up(): void
    {
        Schema::create('track_relationships', function (Blueprint $table) {
            $table->id();

            // Las dos rutas relacionadas
            $table->foreignId('source_track_id')
                ->constrained('tracks')
                ->onDelete('cascade')
                ->comment('Ruta fuente/origen');

            $table->foreignId('target_track_id')
                ->constrained('tracks')
                ->onDelete('cascade')
                ->comment('Ruta destino');

            // Tipo de relación
            $table->enum('relationship_type', [
                'parent_child',    // Padre -> Hijo
                'prerequisite',    // Prerequisito
                'recommendation',  // Recomendación
                'alternative',     // Alternativa
                'corequisite',     // Corequisito (tomar juntos)
                'next_step',       // Siguiente paso
                'specialization'   // Especialización
            ])->default('prerequisite')
                ->comment('Tipo de relación entre rutas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_relationships');
    }
};
