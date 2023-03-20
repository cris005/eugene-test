<?php

namespace App\Http\Controllers;

use App\Http\Requests\MergeDoctorRequest;
use App\Models\Clinic;
use App\Models\ClinicRole;
use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Specialty;
use App\Models\Test;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(): View
    {
        $doctors = Doctor::withCount('tests')->orderBy('updated_at', 'desc')->paginate(100);

        return view('doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        $specialties = Specialty::get();
        $clinics = Clinic::get();
        return view('doctors.create', compact( 'specialties', 'clinics'));
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        $doctor = Doctor::create($request->validated('name'));
        $role = ClinicRole::create([
            'doctor_id' => $doctor->id,
            'specialty_id' => $request->validated('specialty_id'),
            'clinic_id' => $request->validated('clinic_id'),
        ]);
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor): View
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        $specialties = Specialty::get();
        $clinics = Clinic::get();
        return view('doctors.edit', compact('doctor', 'specialties', 'clinics'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update(['name' => $request->validated('name')]);
        $doctor->role->update([
            'specialty_id' => $request->validated('specialty_id'),
            'clinic_id' => $request->validated('clinic_id'),
        ]);
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Returns View to initiate a Doctors merging process
     *
     * @param Doctor $doctor
     * @param string $duplicateUlid
     * @return View
     */
    public function merge(Doctor $doctor, string $duplicateUlid): View
    {
        $duplicate = Doctor::firstWhere(['ulid' => $duplicateUlid]);
        return view('doctors.merge', compact('doctor', 'duplicate'));
    }

    /**
     * Combines 2 Doctor records into 1
     *
     * @param MergeDoctorRequest $request
     * @param Doctor $doctor
     * @param string $duplicateUlid
     * @return RedirectResponse
     */
    public function combine(MergeDoctorRequest $request, Doctor $doctor, string $duplicateUlid): RedirectResponse
    {
        $duplicate = Doctor::firstWhere(['ulid' => $duplicateUlid]);

        // Update the Doctor with the selected fields
        $doctor->update(['name' => $request->validated('name')]);
        $doctor->role->update([
            'specialty_id' => $request->validated('specialty_id'),
            'clinic_id' => $request->validated('clinic_id'),
        ]);

        // Update all tests to be owned by the merged Doctor
        $tests = $duplicate->tests;
        foreach ($tests as $test) {
            $test->update(['referring_doctor_id' => $doctor->id]);
        }

        // We no longer need the duplicate so it can be safely removed
        $duplicate->role->delete();
        $duplicate->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctors merged successfully.');
    }
}
