@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <form method="GET" action="{{ route('recipes.index') }}">
                <div class="form-group">
                    <label for="category">Filter by Category</label>
                    <select class="form-control" id="category" name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $cat == $category ? 'selected' : '' }}>
                                {{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="search">Search Recipes</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-dark" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <div class="row">
        @foreach ($recipes as $recipe)
            <div class="col-md-4">
                <div class="card mb-4 fixed-card">
                    <a href="{{ route('recipes.show', $recipe) }}" class="" style="text-decoration: none; color: black;">
                    @php
                        $images = is_string($recipe->images) ? json_decode($recipe->images, true) : $recipe->images;
                    @endphp
                    @if (is_array($images) && count($images) > 0)
                        <img src="{{ $images[0] }}" class="card-img-top img-fluid custom-image" alt="{{ $recipe->title }}">
                    @else
                        <p>No images available.</p>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <div class="card-text">{{ $recipe->description }}</div>
                    </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links('vendor.pagination.default') }}
    </div>
@endsection
