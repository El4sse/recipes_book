@extends('layouts.app')

@section('content')
    <h1>Edit Recipe</h1>
    <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('recipes._form')
    </form>
@endsection
