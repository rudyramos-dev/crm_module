<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PipelineStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            [
                'name' => 'Lead',
                'color' => '#6366f1',
                'order' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'Contactado',
                'color' => '#f59e0b',
                'order' => 2,
                'is_default' => false,
            ],
            [
                'name' => 'Propuesta',
                'color' => '#3b82f6',
                'order' => 3,
                'is_default' => false,
            ],
            [
                'name' => 'Cerrado',
                'color' => '#10b981',
                'order' => 4,
                'is_default' => false,
            ],
        ];

        foreach ($stages as $stage) {
            DB::table('pipeline_stages')->updateOrInsert(
                ['name' => $stage['name']],
                [
                    'color' => $stage['color'],
                    'order' => $stage['order'],
                    'is_default' => $stage['is_default'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}
