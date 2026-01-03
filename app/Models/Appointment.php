<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'resident_id',
        'service_type',
        'reference_number',
        'scheduled_time',
        'status',
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    /**
     * Get the resident that owns the appointment
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the notes for this appointment
     */
    public function notes()
    {
        return $this->hasMany(AppointmentNote::class);
    }

    /**
     * Generate a unique reference number
     * Format: APT_<SERVICE_TYPE>_MMDDYY_<QUEUE_NUMBER>
     */
    public static function generateReferenceNumber($serviceType = '')
    {
        $today = now()->format('mdy');
        $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
        
        // Create service type code based on service name
        $serviceCode = self::getServiceTypeCode($serviceType);
        
        return 'APT_' . $serviceCode . '_' . $today . '_' . str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Map service type to specific code
     */
    private static function getServiceTypeCode($serviceType)
    {
        $codeMap = [
            'Barangay Clearance' => 'BARCLE',
            'Certificate of Indigency' => 'CERIND',
            'Certificate of Residency' => 'CERRES',
            'Business Permit' => 'BUSPEM',
            'Community Tax Certificate' => 'COMTAX',
            'Other Services' => 'OTHER',
        ];
        
        return $codeMap[$serviceType] ?? strtoupper(substr(str_replace(' ', '', $serviceType), 0, 6));
    }
}
