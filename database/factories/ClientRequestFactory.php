<?php

namespace Database\Factories;

use App\Models\ClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientRequest>
 */
class ClientRequestFactory extends Factory
{
    protected $model = ClientRequest::class;

    public function definition(): array
    {
        $requestTypes = [
            'Consulta jurídica',
            'Representación legal',
            'Revisión contractual',
            'Defensa en proceso penal',
            'Proceso de sucesión',
            'Trámite notarial',
            'Conciliación extrajudicial',
        ];

        $sources = ['Referido', 'Página web', 'Redes sociales', 'Llamada entrante', 'Visita directa', null];

        $requestDate = $this->faker->dateTimeBetween('-6 months', 'now');

        return [
            'client_id'                    => $this->faker->boolean(75) ? Client::inRandomOrder()->value('id') : null,
            'status_id'                    => DB::table('request_statuses')->inRandomOrder()->value('id') ?? 1,
            'created_by'                   => User::inRandomOrder()->value('id') ?? null,
            'request_date'                 => $requestDate,
            'start_date'                   => $this->faker->boolean(60) ? $this->faker->dateTimeBetween($requestDate, '+1 month') : null,
            'deadline_date'                => $this->faker->boolean(50) ? $this->faker->dateTimeBetween('+1 week', '+3 months') : null,
            'title'                        => $this->faker->randomElement($requestTypes) . ' – ' . $this->faker->lastName(),
            'responsible'                  => $this->faker->name(),
            'contact_email'                => $this->faker->boolean(70) ? $this->faker->safeEmail() : null,
            'contact_phone'                => $this->faker->boolean(70) ? $this->faker->numerify('(60#) ###-####') : null,
            'source'                       => $this->faker->randomElement($sources),
            'context'                      => $this->faker->paragraphs(2, true),
            'expected_result_description'  => $this->faker->boolean(60) ? $this->faker->paragraph() : null,
            'request_types'                => json_encode($this->faker->randomElements($requestTypes, $this->faker->numberBetween(1, 3))),
            'expected_results'             => $this->faker->boolean(50) ? json_encode(['Resolución favorable', 'Acuerdo extrajudicial']) : null,
            'documents'                    => null,
        ];
    }
}
