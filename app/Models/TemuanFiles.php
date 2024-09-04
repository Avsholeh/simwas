<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TemuanFiles extends Model
{
    use HasFactory;

    protected $table = 'temuan_files';

    static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $file = "public/$model->url";
            if (Storage::exists($file)) Storage::delete($file);
        });
    }

    public function temuan(): BelongsTo
    {
        return $this->belongsTo(Temuan::class, 'temuan_id', 'id');
    }
}
