<?php

namespace Database\Factories;

use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    protected $model = Step::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'step_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
