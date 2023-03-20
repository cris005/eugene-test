@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Edit Doctor: {{ $doctor->name }}</h1>
    </div>

    <form action="{{ route('doctors.update', $doctor) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $doctor->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="specialty_id" class="block mb-2">Specialty</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="specialty_id">
                @foreach($specialties as $specialty)
                <option value="{{ $specialty->id }}" {{ $specialty->id === $doctor->role->specialty_id ? 'selected="selected"' : '' }}>{{ $specialty->name }}</option>
                @endforeach
            </select>

            @error('specialty_id')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="clinic_id" class="block mb-2">Clinic</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="clinic_id">
                @foreach($clinics as $clinic)
                    <option value="{{ $clinic->id }}" {{ $clinic->id === $doctor->role->clinic_id ? 'selected="selected"' : '' }}>{{ $clinic->ulid . ' - ' . $clinic->name }}</option>
                @endforeach
            </select>

            @error('clinic_id')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Doctor</button>
    </form>
</div>
@endsection
