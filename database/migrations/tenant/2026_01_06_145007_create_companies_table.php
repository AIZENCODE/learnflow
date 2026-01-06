<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Nombre de la empresa');
            $table->string('email')->comment('Email de la empresa');
            $table->string('phone')->comment('Teléfono de la empresa');
            $table->string('address')->comment('Dirección de la empresa');
            $table->string('city')->comment('Ciudad de la empresa');
            $table->string('state')->comment('Estado de la empresa');
            $table->string('zip')->comment('Código postal de la empresa');
            $table->string('country')->comment('País de la empresa');
            $table->string('website')->nullable()->comment('Sitio web de la empresa');

            $table->string('color_hex')->nullable()->comment('Color de la empresa en formato hexadecimal');

            // Multimedia
            $table->string('logo_path')->nullable()->comment('Ruta del logo de la empresa');
            $table->string('favicon_path')->nullable()->comment('Ruta del favicon de la empresa');
            $table->string('banner_path')->nullable()->comment('Ruta del banner de la empresa');
            $table->string('background_path')->nullable()->comment('Ruta del fondo de la empresa');
            $table->string('logo_path_dark')->nullable()->comment('Ruta del logo de la empresa en modo oscuro');
            $table->string('favicon_path_dark')->nullable()->comment('Ruta del favicon de la empresa en modo oscuro');
            $table->string('banner_path_dark')->nullable()->comment('Ruta del banner de la empresa en modo oscuro');
            $table->string('background_path_dark')->nullable()->comment('Ruta del fondo de la empresa en modo oscuro');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->comment('Usuario que creó la empresa');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->comment('Usuario que actualizó la empresa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
