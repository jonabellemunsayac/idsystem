<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentNote extends Model
{
    protected $fillable = [
        'appointment_id',
        'note',
    ];

    /**
     * Get the appointment that owns the note
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
