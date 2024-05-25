@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>{{ $recipe->title }}</h2>
            <div class="float-right">
                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $images = is_string($recipe->images) ? json_decode($recipe->images, true) : $recipe->images;
                @endphp
                @if (is_array($images) && count($images) > 0)
                    @foreach ($images as $image)
                        <div class="col-md-4">
                            <img src="{{ $image }}" class="img-fluid" alt="{{ $recipe->title }}">
                        </div>
                    @endforeach
                @else
                    <p>No images available.</p>
                @endif
            </div>
            <p class="mt-4">{{ $recipe->description }}</p>
            <h5>Ingredients</h5>
            <ul>
                @foreach ($recipe->ingredients as $ingredient)
                    <li>{{ $ingredient->quantity }} {{ $ingredient->unit }} {{ $ingredient->name }}</li>
                @endforeach
            </ul>
            <h5>Steps</h5>
            <ol>
                @foreach ($recipe->steps as $step)
                    <li>{{ $step->description }}</li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
