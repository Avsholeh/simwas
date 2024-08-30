<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Spt extends Model
{
    use HasFactory;

    protected $table = 'spt';

    static function boot()
    {
        parent::boot();

        static::created(function (Spt $spt) {
            $spt->created_by = Auth::id();
        });

        static::updating(function (Spt $spt) {
            $spt->updated_by = Auth::id();
        });

        static::deleting(function (Spt $spt) {
            $spt->deleted_by = Auth::id();
        });
    }

    public function pkpt(): BelongsTo
    {
        return $this->belongsTo(Pkpt::class, 'pkpt_id', 'id');
    }
}
