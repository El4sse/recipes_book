<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'images' => json_encode([
                $this->faker->imageUrl(640, 480, 'food', true, 'Faker'),
                $this->faker->imageUrl(640, 480, 'food', true, 'Faker'),
                $this->faker->imageUrl(640, 480, 'food', true, 'Faker'),
                $this->faker->imageUrl(640, 480, 'food', true, 'Faker'),
                $this->faker->imageUrl(640, 480, 'food', true, 'Faker')
            ]),
            'category' => $this->faker->randomElement([
                'Breakfast recipes',
                'Lunch recipes',
                'Dinner recipes',
                'Appetizer recipes',
                'Salad recipes',
                'Main-course recipes',
                'Side-dish recipes',
                'Baked-goods recipes',
                'Dessert recipes',
                'Snack recipes',
                'Soup recipes',
                'Holiday recipes',
                'Vegetarian dishes',
            ]),
            'period' => $this->faker->numberBetween(5, 120) . ' minutes',
        ];
    }
}
