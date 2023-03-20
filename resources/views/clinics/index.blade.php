@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Clinics</h1>
            <a href="{{ route('clinics.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Clinic</a>
        </div>

        <hr>
        <br>
        {{ $clinics->links() }}
        <br>
        <hr>

        <table class="bg-white w-full border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Updated</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Address</th>
                    <th class="border px-4 py-2">Doctors</th>
                    <th class="border px-4 py-2">Possible Duplicates</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clinics as $clinic)
                    <tr>
                        <td class="border px-4 py-2">{{ $clinic->ulid }}</td>
                        <td class="border px-4 py-2">{{ $clinic->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td class="border px-4 py-2">{{ $clinic->name }}</td>
                        <td class="border px-4 py-2">{{ $clinic->full_address }}</td>
                        <td class="border px-4 py-2">{{ $clinic->doctors_count }}</td>
                        <td class="border px-4 py-2">{{ $clinic->duplicatesCount() }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('clinics.show', $clinic) }}" class="text-white bg-blue-500 px-1.5 rounded">View</a>
                            <a href="{{ route('clinics.edit', $clinic) }}" class="text-white bg-gray-500 px-2.5 rounded">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
