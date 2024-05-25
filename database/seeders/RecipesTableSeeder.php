<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;

class RecipesTableSeeder extends Seeder
{
    public function run()
    {
        Recipe::factory()
            ->count(100)
            ->has(Ingredient::factory()->count(10))
            ->has(Step::factory()->count(5))
            ->create();
    }
}
