@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">{{ $clinic->name }}</h1>
        <a href="{{ route('clinics.edit', $clinic) }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Edit Clinic</a>
    </div>

    <h2 class="text-xl font-bold my-4">Clinic Details</h2>
    <div>General information about this Clinic</div>
    <table class="bg-white w-full border-collapse">
        <thead>
        <tr class="bg-gray-300">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Street Address</th>
            <th class="border px-4 py-2">City</th>
            <th class="border px-4 py-2">State</th>
            <th class="border px-4 py-2">Postcode</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">{{ $clinic->ulid }}</td>
                <td class="border px-4 py-2">{{ $clinic->street_address }}</td>
                <td class="border px-4 py-2">{{ $clinic->city }}</td>
                <td class="border px-4 py-2">{{ $clinic->state }}</td>
                <td class="border px-4 py-2">{{ $clinic->postal_code }}</td>
            </tr>
        </tbody>
    </table>

    <h2 class="text-xl font-bold my-4">Related Doctors</h2>
    <div>List of Doctors working at this Clinic</div>
    <table class="bg-white w-full border-collapse">
        <thead>
            <tr class="bg-gray-300">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Updated</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Specialty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clinic->doctors()->orderBy('created_at', 'desc')->get() as $doctor)
                <tr>
                    <td class="border px-4 py-2">{{ $doctor->ulid }}</td>
                    <td class="border px-4 py-2">{{ $doctor->updated_at->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2">{{ $doctor->doctor->name }}</td>
                    <td class="border px-4 py-2">{{ $doctor->specialty->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-bold my-4">Possibly Duplicated Clinics</h2>
    <div>List of Clinics that are possibly a duplicate of this one</div>
    <table class="bg-white w-full border-collapse">
        <thead>
        <tr class="bg-gray-300">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Updated</th>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Address</th>
            <th class="border px-4 py-2">Duplicate Reason</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clinic->duplicateNames() as $duplicate)
            <tr>
                <td class="border px-4 py-2">{{ $duplicate->ulid }}</td>
                <td class="border px-4 py-2">{{ $duplicate->updated_at->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">{{ $duplicate->name }}</td>
                <td class="border px-4 py-2">{{ $duplicate->full_address }}</td>
                <td class="border px-4 py-2">Similar name</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('clinics.merge', [$clinic, $duplicate]) }}" class="text-white bg-orange-600 px-2 py-1 rounded">Merge</a>
                </td>
            </tr>
        @endforeach
        @foreach($clinic->duplicateAddresses() as $duplicate)
            <tr>
                <td class="border px-4 py-2">{{ $duplicate->ulid }}</td>
                <td class="border px-4 py-2">{{ $duplicate->updated_at->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">{{ $duplicate->name }}</td>
                <td class="border px-4 py-2">{{ $duplicate->full_address }}</td>
                <td class="border px-4 py-2">Similar address</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('clinics.merge', [$clinic, $duplicate]) }}" class="text-white bg-orange-600 px-2 py-1 rounded">Merge</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
