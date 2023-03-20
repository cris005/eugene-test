@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Doctors</h1>
            <a href="{{ route('doctors.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Doctor</a>
        </div>

        <hr>
        <br>
        {{ $doctors->links() }}
        <br>
        <hr>

        <table class="bg-white w-full border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Updated</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Specialty</th>
                    <th class="border px-4 py-2">Clinic Name</th>
                    <th class="border px-4 py-2">Clinic Address</th>
                    <th class="border px-4 py-2">Tests</th>
                    <th class="border px-4 py-2">Possible Duplicates</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td class="border px-4 py-2">{{ $doctor->ulid }}</td>
                        <td class="border px-4 py-2">{{ $doctor->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td class="border px-4 py-2">{{ $doctor->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->role->specialty->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->role->clinic->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->role->clinic->full_address }}</td>
                        <td class="border px-4 py-2">{{ $doctor->tests_count }}</td>
                        <td class="border px-4 py-2">{{ $doctor->duplicateNames(true) }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('doctors.show', $doctor) }}" class="text-white bg-blue-500 px-1.5 rounded">View</a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="text-white bg-gray-500 px-2.5 rounded">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
