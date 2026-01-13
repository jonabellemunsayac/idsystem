<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',   
        'birth_date',
        'civil_status',
        'nationality',
        'special_sector',
        'barangay',
        'house_no',
        'street_name',
        'purok',
        'province',
        'zip_code',
        'address', // Legacy field
        'contact_number',
        'telephone_no',
        'email',
        'blood_type',
        'emergency_contact_name',
        'emergency_contact_no',
        'emergency_contact_relationship',
        'emergency_contact_address',
        'profile_image',
        'signature',
        'family_id',
        'clan_id',
    ];

    // Relationship to ResidentAccount
    public function residentAccount()
    {
        return $this->hasOne(ResidentAccount::class);
    }

    public static function getAllResidents()
    {
        return self::all(); // Equivalent to SELECT * FROM residents
    }

    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }
}
