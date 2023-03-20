@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">{{ $doctor->name }}</h1>
        <a href="{{ route('doctors.edit', $doctor) }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Doctor</a>
    </div>

    <h2 class="text-xl font-bold my-4">Clinic Roles</h2>
    <div>List of roles that this doctor has at different Clinics</div>
    <table class="bg-white w-full border-collapse">
        <thead>
        <tr class="bg-gray-300">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Updated</th>
            <th class="border px-4 py-2">Specialty</th>
            <th class="border px-4 py-2">Clinic Name</th>
            <th class="border px-4 py-2">Clinic Address</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">{{ $doctor->role->ulid }}</td>
                <td class="border px-4 py-2">{{ $doctor->role->updated_at->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">{{ $doctor->role->specialty->name }}</td>
                <td class="border px-4 py-2">{{ $doctor->role->clinic->name }}</td>
                <td class="border px-4 py-2">{{ $doctor->role->clinic->full_address }}</td>
            </tr>
        </tbody>
    </table>

    <h2 class="text-xl font-bold my-4">Possibly Duplicated Doctors</h2>
    <div>List of doctors that are possibly a duplicate of this one</div>
    <table class="bg-white w-full border-collapse">
        <thead>
        <tr class="bg-gray-300">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Updated</th>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Clinic Name</th>
            <th class="border px-4 py-2">Specialty</th>
            <th class="border px-4 py-2">Duplicate Reason</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doctor->duplicateNames() as $duplicate)
            <tr>
                <td class="border px-4 py-2">{{ $duplicate->ulid }}</td>
                <td class="border px-4 py-2">{{ $duplicate->updated_at->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">{{ $duplicate->name }}</td>
                <td class="border px-4 py-2">{{ $duplicate->role->clinic->name }}</td>
                <td class="border px-4 py-2">{{ $duplicate->role->specialty->name }}</td>
                <td class="border px-4 py-2">Similar name</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('doctors.merge', [$doctor, $duplicate]) }}" class="text-white bg-orange-600 px-2 py-1 rounded">Merge</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-bold my-4">Related Tests</h2>
    <div>List of tests related to this doctor</div>
    <table class="bg-white w-full border-collapse">
        <thead>
            <tr class="bg-gray-300">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Updated</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Test Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctor->tests()->orderBy('created_at', 'desc')->get() as $test)
                <tr>
                    <td class="border px-4 py-2">{{ $test->ulid }}</td>
                    <td class="border px-4 py-2">{{ $test->updated_at->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2">{{ $test->name }}</td>
                    <td class="border px-4 py-2">{{ $test->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
