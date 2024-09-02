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

        static::creating(function (Spt $spt) {
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

    public function tim(): BelongsTo
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
