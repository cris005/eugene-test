@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Edit Clinic: {{ $clinic->name }}</h1>
    </div>

    <form action="{{ route('clinics.update', $clinic) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $clinic->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="street_address" class="block mb-2">Street Address</label>
            <input type="text" name="street_address" id="street_address" value="{{ old('street_address', $clinic->street_address) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('street_address')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block mb-2">City</label>
            <input type="text" name="city" id="city" value="{{ old('city', $clinic->city) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('city')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="state" class="block mb-2">State</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="state">
                <option value="ACT" {{ $clinic->state === 'ACT' ? 'selected="selected"' : '' }}>ACT</option>
                <option value="NSW" {{ $clinic->state === 'NSW' ? 'selected="selected"' : '' }}>NSW</option>
                <option value="QLD" {{ $clinic->state === 'QLD' ? 'selected="selected"' : '' }}>VIC</option>
                <option value="VIC" {{ $clinic->state === 'VIC' ? 'selected="selected"' : '' }}>VIC</option>
                <option value="TAS" {{ $clinic->state === 'TAS' ? 'selected="selected"' : '' }}>TAS</option>
                <option value="WA" {{ $clinic->state === 'WA' ? 'selected="selected"' : '' }}>WA</option>
                <option value="SA" {{ $clinic->state === 'SA' ? 'selected="selected"' : '' }}>SA</option>
                <option value="NT" {{ $clinic->state === 'NT' ? 'selected="selected"' : '' }}>NT</option>
            </select>
            @error('state')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="postal_code" class="block mb-2">Postcode</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $clinic->postal_code) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('postal_code')
            <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Clinic</button>
    </form>
</div>
@endsection
