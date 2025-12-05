<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = [
        'nama_kampus', 'akronim', 'kota', 'website', 'akreditasi'
    ];

    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
