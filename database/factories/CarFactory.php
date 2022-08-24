<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $changes = ['manual', 'automatic'];
        $fuel = ['flex', 'gasolina', 'diesel', 'etanol'];
        $bodywork = ['Sedã', 'suv', 'Hatch', 'Picape'];
        return [
            "name" => $this->faker->sentence(3),
            "year" => $this->faker->date('y'),
            "km" => $this->faker->numerify(),
            "price" => $this->faker->numerify(),
            "motor" => $this->faker->numberBetween('1', '9'),
            "change" => $changes[array_rand($changes)],
            "fuel" => $fuel[array_rand($fuel)],
            "end_plate" => $this->faker->numberBetween('1', '9'),
            "color" => $this->faker->colorName(),
            "ipva_paid" => $this->faker->boolean(50),
            "only_owner" => $this->faker->boolean(50),
            "licensed" => $this->faker->boolean(50),
            "bodywork" => $bodywork[array_rand($bodywork)],
            "brand_id" => Car::factory()->create()->id,
            "description" => $this->sequence(6),
        ];
    }
}
