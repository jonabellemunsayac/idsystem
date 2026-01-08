<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $fillable = [
        'clan_name',
        'address',
        'head_of_family',
        'contact_number',
        'email',
        'notes',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}
