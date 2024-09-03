<?php

namespace App\Models;

use App\Enums\SptStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class Pkpt extends Model
{
    use HasFactory, SoftDeletes, CascadesDeletes;

    protected $table = 'pkpt';

    protected $cascadeDeletes = ['spt'];

    static function boot()
    {
        parent::boot();

        static::creating(function ($pkpt) {
            $pkpt->created_by = Auth::id();
        });

        static::created(function ($pkpt) {
            $pkpt->spt()->create([
                'status' => SptStatus::Draft,
                'created_at' => $pkpt->created_at,
            ]);
        });

        static::updating(function ($pkpt) {
            $pkpt->updated_by = Auth::id();
        });

        static::deleting(function ($pkpt) {
            $pkpt->deleted_by = Auth::id();
        });
    }

    public function spt(): HasOne
    {
        return $this->hasOne(Spt::class, 'pkpt_id', 'id');
    }

    public function inspektur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspektur_id', 'id')->whereNot('is_developer', 1);
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
