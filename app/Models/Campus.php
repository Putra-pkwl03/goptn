<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = [
        'nama_kampus',
        'akronim',
        'alamat',
        'kota',
        'website',
        'akreditasi',
        'deskripsi',
        'jalur_masuk', 
    ];

    protected $casts = [
        'jalur_masuk' => 'array', 
    ];

    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
