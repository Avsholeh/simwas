<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, CascadesDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $cascadeDeletes = ['anggota'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            $model->anggota()->create();
        });

        static::restored(function ($model) {
            $model->anggota()->restore();
        });
    }

    public function anggota(): HasOne
    {
        return $this->hasOne(Anggota::class, 'user_id', 'id');
    }
}
