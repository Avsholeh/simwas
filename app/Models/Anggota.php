<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class Anggota extends Model
{
    use HasFactory, SoftDeletes, CascadesDeletes;

    protected $table = 'anggota';

    protected $cascadeDeletes = ['timAnggota'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tim(): BelongsToMany
    {
        return $this->belongsToMany(Tim::class, 'tim_anggota', 'anggota_id', 'tim_id')->wherePivotNull('deleted_at');
    }

    public function timAnggota(): HasMany
    {
        return $this->hasMany(TimAnggota::class, 'anggota_id', 'id');
    }
}
