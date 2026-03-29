<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $legalSuffixes  = ['& Asociados', 'S.A.S.', 'Ltda.', 'S.A.', '& Cía.', 'Corp.', 'E.U.'];
        $legalPrefixes  = ['Bufete', 'Consultoría Jurídica', 'Grupo Empresarial', 'Inversiones', 'Constructora'];

        $companyName = $this->faker->boolean(60)
            ? $this->faker->lastName() . ' ' . $this->faker->randomElement($legalSuffixes)
            : $this->faker->randomElement($legalPrefixes) . ' ' . $this->faker->lastName();

        return [
            'name'           => $companyName,
            'email'          => $this->faker->unique()->safeEmail(),
            'phone'          => $this->faker->numerify('(60#) ###-####'),
            'website'        => $this->faker->boolean(40) ? 'https://www.' . $this->faker->domainName() : null,
            'location'       => $this->faker->randomElement(['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Bucaramanga', 'Cartagena', 'Pereira', 'Manizales']),
            'contact_person' => $this->faker->name(),
            'address'        => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'notes'          => $this->faker->boolean(30) ? $this->faker->sentence(12) : null,
            'is_active'      => $this->faker->boolean(85),
            'created_by'     => User::inRandomOrder()->value('id') ?? User::factory(),
        ];
    }

    /**
     * Estado: cliente inactivo.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Estado: cliente activo.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}
