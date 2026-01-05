<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();

        Track::create([
            'name' => 'Desarrollo Web Full Stack',
            'description' => 'Ruta completa para convertirte en desarrollador web full stack, desde fundamentos hasta tecnologías avanzadas.',
            'order' => 1,
            'xp_points' => 1000,
            'has_time_limit' => false,
            'time_limit_type' => 'self_paced',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        Track::create([
            'name' => 'Marketing Digital',
            'description' => 'Aprende estrategias de marketing digital, SEO, redes sociales y publicidad online.',
            'order' => 2,
            'xp_points' => 800,
            'has_time_limit' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'time_limit_type' => 'fixed_date',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        Track::create([
            'name' => 'Diseño UX/UI',
            'description' => 'Domina el diseño de experiencias de usuario y interfaces atractivas y funcionales.',
            'order' => 3,
            'xp_points' => 750,
            'has_time_limit' => false,
            'time_limit_type' => 'self_paced',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
    }
}
