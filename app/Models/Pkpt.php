<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Pkpt extends Model
{
    use HasFactory;

    protected $table = 'pkpt';

    static function boot()
    {
        parent::boot();

        static::created(function ($pkpt) {
            $pkpt->spt?->create();
            $pkpt->created_by = Auth::id();
        });

        static::updating(function ($pkpt) {
            $pkpt->updated_by = Auth::id();
        });

        static::deleting(function ($pkpt) {
            $pkpt->deleted_by = Auth::id();
            $pkpt->spt?->delete();
        });
    }

    public function spt(): HasOne
    {
        return $this->hasOne(Spt::class, 'pkpt_id', 'id');
    }
}
