<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\ClinicRole;
use App\Models\Doctor;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Spatie\Geocoder\Geocoder;

class ClinicsTableSeeder extends Seeder
{
    public function run()
    {
        // Default Clinic
        Clinic::create([
            'id' => 1,
            'name' => 'Unknown',
            'street_address' => null,
            'state' => null,
            'city' => null,
            'postal_code' => null,
            'latitude' => null,
            'longitude' => null
        ]);

        // Seed Clinics from doctors' data
        $this->insertClinics();
    }

    /**
     * Insert all current clinics available
     *
     * @return void
     */
    public function insertClinics(): void
    {
        $doctors = Doctor::get();
        foreach ($doctors as $doctor) {
            $data = $this->deconstructAddress($doctor->clinic_address);
            $data['name'] = $doctor->clinic_name;
            $clinic = Clinic::create($data);
            $this->normalizeDoctors($doctor, $clinic);
        }
    }

    /**
     * Normalize the Doctors' data
     *
     * @param Doctor $doctor
     * @param Clinic $clinic
     * @return void
     */
    public function normalizeDoctors(Doctor $doctor, Clinic $clinic): void
    {
        $specialtyId = match ($doctor->specialty) {
            'GP', 'General Practitioner' => 2,
            'OB-GYN' => 3,
            'Obstetrician' => 4,
            'Gynaecologist' => 5,
            default => 1, // Unknown
        };

        ClinicRole::create([
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'specialty_id' => $specialtyId
        ]);
    }

    /**
     * Deconstruct an address string into an array
     *
     * @param string $address
     * @return array
     */
    public function deconstructAddress(string $address): array
    {
        $addressParts = explode(',', $address);
        $geocode = $this->findGeocode($address);

        switch (count($addressParts)) {
            case 3:
                $state = $this->findState($addressParts[2]);
                return [
                    'street_address' => trim($addressParts[0]),
                    'city' => trim($addressParts[1]),
                    'state' => $state['state'],
                    'postal_code' => $state['postal_code'],
                    'latitude' => $geocode['lat'],
                    'longitude' => $geocode['lng']
                ];
            case 2:
                $state = $this->findState($addressParts[1], true);
                return [
                    'street_address' => trim($addressParts[0]),
                    'city' => $state['city'],
                    'state' => $state['state'],
                    'postal_code' => $state['postal_code'],
                    'latitude' => $geocode['lat'],
                    'longitude' => $geocode['lng']
                ];
            default:
                $state = $this->findState(substr($addressParts[0], -8, 8));
                $streetAddress = $state['state'] !== null
                    ? trim(substr_replace($addressParts[0], '', -8))
                    : null;

                return [
                    'street_address' => $streetAddress,
                    'city' => null,
                    'state' => $state['state'],
                    'postal_code' => $state['postal_code'],
                    'latitude' => $geocode['lat'],
                    'longitude' => $geocode['lng']
                ];
        }
    }

    /**
     * Find state details from provided string
     *
     * @param string $addressPart
     * @param bool $includeCity
     * @return array|null[]
     */
    public function findState(string $addressPart, bool $includeCity = false): array
    {
        $state = trim(substr($addressPart, 0, 4));
        $postcode = substr($addressPart, -4);

        $result = match ($state) {
            'ACT', 'NSW', 'WA', 'SA', 'NT', 'VIC', 'QLD', 'TAS' => [
                'state' => trim($state),
                'postal_code' => is_numeric($postcode) ? $postcode : null
            ],
            default => [
                'city' => null,
                'state' => null,
                'postal_code' => null
            ],
        };

        if ($includeCity && $result['state'] !== null) {
            $result['city'] = trim(substr_replace($addressPart, '', -8));
        }

        return $result;
    }

    /**
     * Find the geocode data of an address string
     *
     * @param string $address
     * @return array|null[]
     */
    public function findGeocode(string $address): array
    {
        if (empty($address)) {
            return [
                'lat' => null,
                'lng' => null
            ];
        }

        $config = config('app.env') === 'local' ? ['verify' => false] : [];
        $client = new Client($config);
        $geocoder = new Geocoder($client);
        $geocoder
            ->setApiKey(config('geocoder.key'))
            ->setCountry(config('geocoder.country'))
            ->setLanguage(config('geocoder.language'));

        return $geocoder->getCoordinatesForAddress($address);
    }
}
