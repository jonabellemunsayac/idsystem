<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
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
        'household_composition',
        'height_cm',
        'weight_kg',
        'religion',
        'spouse_name',
        'children_names',
        'father_name',
        'mother_maiden_name',
        'residency_type',
        'tenure_status',
        'length_of_stay',
        'registered_voter',
        'precinct_no',
        'occupation',
        'employment_type',
        'economic_status',
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

    public function getDisplayNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->suffix,
            $this->middle_name,
            $this->last_name,
        ])));
    }
}
