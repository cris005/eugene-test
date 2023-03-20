<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Uid\Ulid;

class AbstractModel extends Model
{
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (AbstractModel $model) {
            $model->ulid = Ulid::generate();
        });
    }
}
