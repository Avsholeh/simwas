<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class Tim extends Model
{
    use HasFactory, SoftDeletes, CascadesDeletes;

    protected $table = 'tim';

    protected $cascadeDeletes = ['timAnggota'];

    public function anggota(): BelongsToMany
    {
        return $this->belongsToMany(Anggota::class, 'tim_anggota', 'tim_id', 'anggota_id')->wherePivotNull('deleted_at');
    }

    public function timAnggota(): HasMany
    {
        return $this->hasMany(TimAnggota::class, 'tim_id', 'id');
    }

    public function statusAktif(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif',
        );
    }
}
