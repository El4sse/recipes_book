@extends('layouts.app')

@section('content')
    <h1>Add New Recipe</h1>
    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @include('recipes._form')
    </form>
@endsection
