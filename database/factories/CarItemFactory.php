<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarItem;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarItemFactory extends Factory
{
    protected $model = CarItem::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "item_id"=>Item::factory()->create()->id,
            "car_id"=>Car::factory()->create()->id
        ];
    }
}
