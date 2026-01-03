<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ID extends Model
{
    protected $table = 'ids';

    protected $fillable = [
        'resident_id',
        'id_type',
        'id_number',
        'issued_by',
        'issued_date',
        'expiration_date',
        'qr_code',
        'qr_code_url',
    ];

    protected $dates = [
        'issued_date',
        'expiration_date',
        'created_at',
        'updated_at',
    ];

    // Relationship to Resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
