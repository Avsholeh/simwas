<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class TimAnggota extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'tim_anggota';

    public $timestamps = false;

    public function tim(): BelongsTo
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id');
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }

    public function posisi(): BelongsTo
    {
        return $this->belongsTo(TimPosisi::class, 'posisi_id', 'id');
    }
}
