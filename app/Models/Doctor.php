<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends AbstractModel
{
    use HasFactory;

    public function role(): HasOne
    {
        // TODO: allow doctors to have multiple roles (e.g. work in different clinics)
        return $this->hasOne(ClinicRole::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'referring_doctor_id');
    }

    /**
     * Will find very similar names
     *
     * @param bool $count
     * @return Collection|int
     */
    public function duplicateNames(bool $count = false): Collection|int
    {
        $query = Doctor::where('name', 'LIKE', $this->name)
            ->where('ulid', '<>', $this->ulid);
        return $count ? $query->count() : $query->get();
    }
}
