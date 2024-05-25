@csrf
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $recipe->title ?? '') }}" required>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $recipe->description ?? '') }}</textarea>
</div>
<div class="form-group">
    <label for="images">Images (max 5)</label>
    <input type="file" class="form-control-file" id="images" name="images[]" multiple accept="image/*">
</div>
<div class="form-group">
    <label for="category">Category</label>
    <select class="form-control" id="category" name="category" required>
        @foreach(['Breakfast recipes', 'Lunch recipes', 'Dinner recipes', 'Appetizer recipes', 'Salad recipes', 'Main-course recipes', 'Side-dish recipes', 'Baked-goods recipes', 'Dessert recipes', 'Snack recipes', 'Soup recipes', 'Holiday recipes', 'Vegetarian dishes'] as $category)
            <option value="{{ $category }}" {{ old('category', $recipe->category ?? '') == $category ? 'selected' : '' }}>{{ $category }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="period">Period (minutes)</label>
    <input type="number" class="form-control" id="period" name="period" value="{{ old('period', $recipe->period ?? '') }}" required oninput="updatePeriodCounter()">
    <small id="periodHelp" class="form-text text-muted">The period in minutes.</small>
    <div class="progress mt-2">
        <div id="periodCounter" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="form-group">
    <label for="ingredients">Ingredients</label>
    <div id="ingredients">
        @foreach (old('ingredients', $recipe->ingredients ?? []) as $ingredient)
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="ingredients[{{ $loop->index }}][name]" placeholder="Name" value="{{ $ingredient['name'] ?? $ingredient->name }}" required>
                <input type="text" class="form-control" name="ingredients[{{ $loop->index }}][quantity]" placeholder="Quantity" value="{{ $ingredient['quantity'] ?? $ingredient->quantity }}" required>
                <select class="form-control" name="ingredients[{{ $loop->index }}][unit]" required>
                    <option value="g" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'g') ? 'selected' : '' }}>g</option>
                    <option value="kg" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'kg') ? 'selected' : '' }}>kg</option>
                    <option value="ml" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'ml') ? 'selected' : '' }}>ml</option>
                    <option value="l" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'l') ? 'selected' : '' }}>l</option>
                    <option value="cup" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'cup') ? 'selected' : '' }}>cup</option>
                    <option value="tbsp" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'tbsp') ? 'selected' : '' }}>tbsp</option>
                    <option value="tsp" {{ (isset($ingredient['unit']) && $ingredient['unit'] == 'tsp') ? 'selected' : '' }}>tsp</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-danger remove-ingredient" type="button">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
    <button class="btn btn-secondary" id="add-ingredient" type="button">Add Ingredient</button>
</div>
<div class="form-group">
    <label for="steps">Steps</label>
    <div id="steps">
        @foreach (old('steps', $recipe->steps ?? []) as $step)
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="steps[{{ $loop->index }}][description]" placeholder="Step Description" value="{{ $step['description'] ?? $step->description }}" required>
                <input type="number" class="form-control" name="steps[{{ $loop->index }}][step_order]" placeholder="Order" value="{{ $step['step_order'] ?? $step->step_order }}" required>
                <div class="input-group-append">
                    <button class="btn btn-danger remove-step" type="button">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
    <button class="btn btn-secondary" id="add-step" type="button">Add Step</button>
</div>
<button type="submit" class="btn btn-primary">Save Recipe</button>

<script>
    function updatePeriodCounter() {
        const periodInput = document.getElementById('period');
        const periodCounter = document.getElementById('periodCounter');
        const value = periodInput.value;

        let percentage = 0;
        if (value) {
            const max = periodInput.getAttribute('max') || 120; // Assume 120 minutes as max if not set
            percentage = Math.min((value / max) * 100, 100);
        }

        periodCounter.style.width = `${percentage}%`;
        periodCounter.setAttribute('aria-valuenow', percentage);
        periodCounter.innerHTML = `${value} minutes`;
    }

    document.getElementById('add-ingredient').addEventListener('click', function() {
        const index = document.querySelectorAll('#ingredients .input-group').length;
        const ingredientTemplate = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="ingredients[${index}][name]" placeholder="Name" required>
                <input type="text" class="form-control" name="ingredients[${index}][quantity]" placeholder="Quantity" required>
                <select class="form-control" name="ingredients[${index}][unit]" required>
                    <option value="g">g</option>
                    <option value="kg">kg</option>
                    <option value="ml">ml</option>
                    <option value="l">l</option>
                    <option value="cup">cup</option>
                    <option value="tbsp">tbsp</option>
                    <option value="tsp">tsp</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-danger remove-ingredient" type="button">Remove</button>
                </div>
            </div>
        `;
        document.getElementById('ingredients').insertAdjacentHTML('beforeend', ingredientTemplate);
    });

    document.getElementById('add-step').addEventListener('click', function() {
        const index = document.querySelectorAll('#steps .input-group').length;
        const stepTemplate = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="steps[${index}][description]" placeholder="Step Description" required>
                <input type="number" class="form-control" name="steps[${index}][step_order]" placeholder="Order" required>
                <div class="input-group-append">
                    <button class="btn btn-danger remove-step" type="button">Remove</button>
                </div>
            </div>
        `;
        document.getElementById('steps').insertAdjacentHTML('beforeend', stepTemplate);
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-ingredient')) {
            event.target.closest('.input-group').remove();
        } else if (event.target.classList.contains('remove-step')) {
            event.target.closest('.input-group').remove();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        updatePeriodCounter(); // Initialize counter on page load
    });
</script>
