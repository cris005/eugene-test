<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends AbstractModel
{
    protected $guarded = [];

    public function doctors(): HasMany
    {
        return $this->hasMany(ClinicRole::class, 'clinic_id');
    }

    /**
     * Will find very similar names
     *
     * @param bool $count
     * @return Collection|int
     */
    public function duplicateNames(bool $count = false): Collection|int
    {
        $query = Clinic::where('name', 'LIKE', $this->name)
            ->where('ulid', '<>', $this->ulid);
        return $count ? $query->count() : $query->get();
    }

    /**
     * Will find duplicate street addresses
     *
     * @param bool $count
     * @return Collection|int
     */
    public function duplicateAddresses(bool $count = false): Collection|int
    {
        $query = Clinic::where(['street_address' => $this->street_address])
            ->where('ulid', '<>', $this->ulid);
        return $count ? $query->count() : $query->get();
    }

    /**
     * Will count the amount of possible duplicates
     *
     * @return int
     */
    public function duplicatesCount(): int
    {
        return $this->duplicateNames(true) + $this->duplicateAddresses(true);
    }

    /**
     * Build a read-only property for the Clinic's full address
     *
     * @return Attribute
     */
    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->getFullAddress()
        );
    }

    /**
     * Build the full address string
     *
     * @return string
     */
    public function getFullAddress(): string
    {
        return implode(", ", array_filter([
            $this->street_address,
            $this->city,
            $this->state,
            $this->postal_code
        ]));
    }
}
