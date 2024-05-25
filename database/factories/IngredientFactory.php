<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'quantity' => $this->faker->randomDigitNotNull,
            'unit' => $this->faker->randomElement(['g', 'kg', 'ml', 'l', 'cup', 'tsp', 'tbsp']),
        ];
    }
}
