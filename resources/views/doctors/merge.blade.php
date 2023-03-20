@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Merging Doctors: {{ $doctor->name }} (Doctor A) & {{ $duplicate->name }} (Doctor B)</h1>
    </div>

    <div class="py-4"><span class="font-bold">Instructions:</span> Please select below which fields you wish to keep upon merging these 2 Doctors</div>

    <form action="{{ route('doctors.combine', [$doctor, $duplicate]) }}" method="post">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="name" class="block mb-2">Name</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name">
                <option value="{{ $doctor->name }}" selected="selected">[Doctor A] {{ $doctor->name }}</option>
                <option value="{{ $duplicate->name }}">[Doctor B] {{ $duplicate->name }}</option>
            </select>
            @error('name')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="specialty_id" class="block mb-2">Specialty</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="specialty_id">
                <option value="{{ $doctor->role->specialty_id }}" selected="selected">[Doctor A] {{ $doctor->role->specialty->name }}</option>
                <option value="{{ $duplicate->role->specialty_id }}">[Doctor B] {{ $duplicate->role->specialty->name }}</option>
            </select>
            @error('specialty_id')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="clinic_id" class="block mb-2">Clinic</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="clinic_id">
                <option value="{{ $doctor->role->clinic_id }}" selected="selected">[Doctor A] {{ $doctor->role->clinic->name }}</option>
                <option value="{{ $duplicate->role->clinic_id }}">[Doctor B] {{ $duplicate->role->clinic->name }}</option>
            </select>
            @error('clinic_id')
                <p class="text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Merge Doctors</button>
    </form>
</div>
@endsection
