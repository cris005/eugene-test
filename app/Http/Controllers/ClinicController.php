<?php

namespace App\Http\Controllers;

use App\Http\Requests\MergeClinicRequest;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Models\Clinic;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Geocoder\Geocoder;

class ClinicController extends Controller
{
    public function index(): View
    {
        $clinics = Clinic::withCount('doctors')->orderBy('name', 'desc')->paginate(100);

        return view('clinics.index', compact('clinics'));
    }

    public function create(): View
    {
        return view('clinics.create');
    }

    public function store(StoreClinicRequest $request): RedirectResponse
    {
        $clinic = Clinic::create($request->validated());
        $this->insertGeocode($clinic);
        return redirect()->route('clinics.index')->with('success', 'Clinic created successfully.');
    }

    public function show(Clinic $clinic): View
    {
        return view('clinics.show', compact('clinic'));
    }

    public function edit(Clinic $clinic): View
    {
        return view('clinics.edit', compact('clinic'));
    }

    public function update(UpdateClinicRequest $request, Clinic $clinic): RedirectResponse
    {
        $clinic->update($request->validated());
        $this->insertGeocode($clinic);
        return redirect()->route('clinics.index')->with('success', 'Clinic updated successfully.');
    }

    /**
     * Returns View to initiate a Clinics merging process
     *
     * @param Clinic $clinic
     * @param string $duplicateUlid
     * @return View
     */
    public function merge(Clinic $clinic, string $duplicateUlid): View
    {
        $duplicate = Clinic::firstWhere(['ulid' => $duplicateUlid]);
        return view('clinics.merge', compact('clinic', 'duplicate'));
    }

    /**
     * Combines 2 Clinic records into 1
     *
     * @param MergeClinicRequest $request
     * @param Clinic $clinic
     * @param string $duplicateUlid
     * @return RedirectResponse
     */
    public function combine(MergeClinicRequest $request, Clinic $clinic, string $duplicateUlid): RedirectResponse
    {
        $duplicate = Clinic::firstWhere(['ulid' => $duplicateUlid]);

        // Update the Clinic with the selected fields
        $clinic->update($request->validated());
        $this->insertGeocode($clinic);

        // Move all the doctors from the duplicate to the merged Clinic
        $doctors = $duplicate->doctors;
        foreach ($doctors as $doctor) {
            $doctor->update(['clinic_id' => $clinic->id]);
        }

        // We no longer need the duplicate so it can be safely removed
        $duplicate->delete();

        return redirect()->route('clinics.index')->with('success', 'Clinics merged successfully.');
    }

    /**
     * Finds and inserts the Geocode Coordinates of a Clinic
     *
     * @param Clinic $clinic
     * @return void
     */
    private function insertGeocode(Clinic $clinic): void
    {
        $address = implode(", ", array_filter([
            $clinic->street_address,
            $clinic->city,
            $clinic->state,
            $clinic->postal_code
        ]));

        $config = config('app.env') === 'local' ? ['verify' => false] : [];
        $client = new Client($config);
        $geocoder = new Geocoder($client);
        $geocoder
            ->setApiKey(config('geocoder.key'))
            ->setCountry(config('geocoder.country'))
            ->setLanguage(config('geocoder.language'));

        $coordinates = $geocoder->getCoordinatesForAddress($address);

        $clinic->update([
            'latitude'  => $coordinates['lat'],
            'longitude' => $coordinates['lng']
        ]);
    }
}
