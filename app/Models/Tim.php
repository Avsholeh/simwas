<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tim';

    public function anggota(): BelongsToMany
    {
        return $this->belongsToMany(Anggota::class, 'tim_anggota', 'tim_id', 'anggota_id');
    }
}
