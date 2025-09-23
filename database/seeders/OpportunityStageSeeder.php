<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OpportunityStage;
use App\Models\Companies;
use App\Models\User;

class OpportunityStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener la primera compañía y usuario para los ejemplos
        $company = Companies::first();
        $user = User::first();

        if (!$company || !$user) {
            $this->command->warn('No se encontraron compañías o usuarios. Asegúrate de ejecutar los seeders correspondientes primero.');
            return;
        }

        $stages = [
            [
                'name' => 'Prospecto',
                'description' => 'Cliente potencial identificado, sin contacto inicial establecido.',
                'order' => 1,
                'closing_percentage' => 10.00,
                'colour' => '#6c757d',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Contacto Inicial',
                'description' => 'Primer contacto establecido con el prospecto.',
                'order' => 2,
                'closing_percentage' => 20.00,
                'colour' => '#17a2b8',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Calificación',
                'description' => 'Evaluación de la necesidad y capacidad de compra del prospecto.',
                'order' => 3,
                'closing_percentage' => 30.00,
                'colour' => '#ffc107',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Presentación',
                'description' => 'Presentación de la propuesta o demostración del producto/servicio.',
                'order' => 4,
                'closing_percentage' => 50.00,
                'colour' => '#fd7e14',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Negociación',
                'description' => 'Discusión de términos, precios y condiciones.',
                'order' => 5,
                'closing_percentage' => 75.00,
                'colour' => '#e83e8c',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Propuesta Enviada',
                'description' => 'Propuesta formal enviada al cliente para revisión.',
                'order' => 6,
                'closing_percentage' => 85.00,
                'colour' => '#6f42c1',
                'is_closing_stage' => false,
            ],
            [
                'name' => 'Cerrado - Ganado',
                'description' => 'Oportunidad cerrada exitosamente, cliente adquirió el producto/servicio.',
                'order' => 7,
                'closing_percentage' => 100.00,
                'colour' => '#28a745',
                'is_closing_stage' => true,
            ],
            [
                'name' => 'Cerrado - Perdido',
                'description' => 'Oportunidad cerrada sin éxito, cliente no adquirió el producto/servicio.',
                'order' => 8,
                'closing_percentage' => 0.00,
                'colour' => '#dc3545',
                'is_closing_stage' => true,
            ],
        ];

        foreach ($stages as $stageData) {
            OpportunityStage::create(array_merge($stageData, [
                'company_id' => $company->id,
                'created_by' => $user->id,
                'status' => true,
                'is_delete' => false,
            ]));
        }

        $this->command->info('Etapas de oportunidades creadas exitosamente.');
    }
}