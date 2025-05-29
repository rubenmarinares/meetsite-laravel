<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Academia>
 */
class AcademiaFactory extends Factory
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
            'academia'=> 'Academia ' . ucfirst($faker->word),
            'status'=>$this->faker->boolean(),
            'fecha' => intval($this->faker->dateTime()->format('Ymd')),
            'properties' =>  json_encode([
                'capacidad' => $this->faker->numberBetween(1, 20),
                'tipo' => $this->faker->randomElement(['pública', 'privada', 'concertada','otros']),                
            ]),
            'direccion' => $faker->address,
            'localidad' => $faker->city
        ];
    }
}
