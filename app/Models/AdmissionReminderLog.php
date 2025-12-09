<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionReminderLog extends Model
{
    protected $fillable = [
        'user_id',
        'admission_item_id',
        'category',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admissionItem()
    {
        return $this->belongsTo(AdmissionItem::class);
    }
}
