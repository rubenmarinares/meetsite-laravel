<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aula>
 */
class AulaFactory extends Factory
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
            'aula'=> 'Aula ' . ucfirst($faker->word),
            'status'=>true,
            'properties' =>  json_encode([
                'capacidad' => $this->faker->numberBetween(1, 20)                
            ]),
            
        ];
    }
}
