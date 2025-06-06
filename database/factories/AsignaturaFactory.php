<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asignatura>
 */
class AsignaturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $this->faker = \Faker\Factory::create('es_ES');

       return [
            'asignatura'=> $this->faker->sentence(3),  
            'descripcion' => $this->faker->optional(0.7)->paragraph(),        
            'status'=>true
        ];
    }
}
