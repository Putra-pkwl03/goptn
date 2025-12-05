<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'campus_id',
        'name',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
