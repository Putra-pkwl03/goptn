<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'campus_id', 'nama_jurusan', 'fakultas', 'akreditasi', 'kapasitas'
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
