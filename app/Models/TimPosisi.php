<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimPosisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tim_posisi';

    public $timestamps = false;
}
