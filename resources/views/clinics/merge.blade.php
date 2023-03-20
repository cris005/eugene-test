@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Merging Clinics: {{ $clinic->name }} (Clinic A) & {{ $duplicate->name }} (Clinic B)</h1>
    </div>

    <div class="py-4"><span class="font-bold">Instructions:</span> Please select below which fields you wish to keep upon merging these 2 Clinics</div>

    <form action="{{ route('clinics.combine', [$clinic, $duplicate]) }}" method="post">
        @csrf
        @method('POST')

        <div class="my-4">
            <label for="name" class="block mb-2">Name</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name">
                <option value="{{ $clinic->name }}" selected="selected">[Clinic A] {{ $clinic->name }}</option>
                <option value="{{ $duplicate->name }}">[Clinic B] {{ $duplicate->name }}</option>
            </select>
            @error('name')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="street_address" class="block mb-2">Street Address</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="street_address">
                <option value="{{ $clinic->street_address }}" selected="selected">[Clinic A] {{ $clinic->street_address }}</option>
                <option value="{{ $duplicate->street_address }}">[Clinic B] {{ $duplicate->street_address }}</option>
            </select>
            @error('street_address')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block mb-2">City</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="city">
                <option value="{{ $clinic->city }}" selected="selected">[Clinic A] {{ $clinic->city }}</option>
                <option value="{{ $duplicate->city }}">[Clinic B] {{ $duplicate->city }}</option>
            </select>
            @error('city')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="state" class="block mb-2">State</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="state">
                <option value="{{ $clinic->state }}" selected="selected">[Clinic A] {{ $clinic->state }}</option>
                <option value="{{ $duplicate->state }}">[Clinic B] {{ $duplicate->state }}</option>
            </select>
            @error('state')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="postal_code" class="block mb-2">Postcode</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="postal_code">
                <option value="{{ $clinic->postal_code }}" selected="selected">[Clinic A] {{ $clinic->postal_code }}</option>
                <option value="{{ $duplicate->postal_code }}">[Clinic B] {{ $duplicate->postal_code }}</option>
            </select>
            @error('postal_code')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Merge Clinics</button>
    </form>
</div>
@endsection
