<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('es_ES');

        
       return [
            'nombre'=>  ucfirst($faker->firstName),
            'apellidos'=>  ucfirst($faker->lastName()),
            'email'=>  $faker->email,
            'status'=>$this->faker->boolean(),
            'fecha' => intval($this->faker->dateTime()->format('Ymd'))            
        ];
    }
}
