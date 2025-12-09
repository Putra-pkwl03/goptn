<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

       protected $fillable = [
        'name',
        'email',
        'no_telp',
        'password',
        'role',
        'wants_notification',
        'notification_type',  
        'campus_id'           
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

      protected $casts = [
        'wants_notification' => 'boolean',
        'notification_type' => 'array',
    ];

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function ptnChoices()
    {
        return $this->hasMany(StudentPTNChoice::class);
    }

    public function entryPaths()
    {
        return $this->hasMany(StudentEntryPath::class);
    }

    public function admissionItems()
    {
        return $this->hasManyThrough(
            AdmissionItem::class,
            JadwalAdmission::class,
            'category',
            'admission_id', 
            'entry_path_id', 
            'id' 
        );
    }
}
