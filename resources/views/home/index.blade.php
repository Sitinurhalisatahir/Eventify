@extends('layouts.app')

@section('title', 'Home - Find Your Next Event')

@section('content')
    <!-- Hero Section -->
    @include('home.partials.hero')

    <!-- Featured Events -->
    @include('home.partials.featured-events')

    <!-- Categories -->
    @include('home.partials.categories')

    <!-- Upcoming Events -->
    @include('home.partials.upcoming-events')

     <!-- ⭐⭐ BARU: Past Events -->
    @include('home.partials.past-events')
    
@endsection