<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlotterRecord extends Model
{
    protected $table = 'blotter_records';

    protected $fillable = [
        'case_number',
        'complainant_name',
        'complainant_contact',
        'respondent_name',
        'respondent_contact',
        'incident_type',
        'incident_location',
        'details',
        'incident_date',
        'severity',
        'status',
        'witnesses',
        'notes',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
