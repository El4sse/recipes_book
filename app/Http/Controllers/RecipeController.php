<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');
        $recipesQuery = Recipe::query();

        if ($category) {
            $recipesQuery->where('category', $category);
        }

        if ($search) {
            $recipesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('ingredients', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $recipes = $recipesQuery->orderBy('created_at', 'desc')->paginate(10);

        $categories = [
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
        ];

        return view('recipes.index', compact('recipes', 'categories', 'category', 'search'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string',
            'period' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity' => 'required|string',
            'ingredients.*.unit' => 'required|string',
            'steps' => 'required|array',
            'steps.*.description' => 'required|string',
            'steps.*.step_order' => 'required|integer',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = Storage::url($path);
            }
            $validated['images'] = json_encode($images);
        } else {
            $validated['images'] = json_encode([]);
        }

        $recipe = Recipe::create($validated);

        foreach ($validated['ingredients'] as $ingredient) {
            $recipe->ingredients()->create($ingredient);
        }

        foreach ($validated['steps'] as $step) {
            $recipe->steps()->create($step);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string',
            'period' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity' => 'required|string',
            'ingredients.*.unit' => 'required|string',
            'steps' => 'required|array',
            'steps.*.description' => 'required|string',
            'steps.*.step_order' => 'required|integer',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = asset('storage/' . substr($path, 7)); // Remove 'public/' from the path
            }
            $validated['images'] = json_encode($images);
        } else {
            $validated['images'] = $recipe->images; // Keep the existing images if no new images are uploaded
        }

        $recipe->update($validated);

        $recipe->ingredients()->delete();
        foreach ($validated['ingredients'] as $ingredient) {
            $recipe->ingredients()->create($ingredient);
        }

        $recipe->steps()->delete();
        foreach ($validated['steps'] as $step) {
            $recipe->steps()->create($step);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }
}
