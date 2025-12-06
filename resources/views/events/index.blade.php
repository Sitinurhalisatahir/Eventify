@extends('layouts.app')

@section('title', 'jelajahi acara - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Jelajahi Acara</h1>
            <p class="text-gray-600">Temukan acara menarik di sekitar Anda</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                @include('events.partials.filter-sidebar')
            </div>

            <!-- Events Content -->
            <div class="lg:w-3/4">
                <!-- Sort Header -->
                @include('events.partials.sort-header')
                
                <!-- Events Grid -->
                @include('events.partials.event-grid')
            </div>
        </div>
    </div>
</div>
@endsection