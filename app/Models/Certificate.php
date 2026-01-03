<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'resident_id',
        'reference_number',
        'type',
        'purpose',
        'purpose_details',
        'status',
        'pickup_or_delivery',
        'delivery_address',
        'approved_date',
        'released_date',
        'approved_by',
        'released_by',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'approved_date' => 'date',
        'released_date' => 'date',
    ];

    /**
     * Get the resident that owns the certificate.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the user who approved the certificate.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who released the certificate.
     */
    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by');
    }

    /**
     * Generate a unique reference number.
     * Format: CERT_<TYPE>_MMDDYY_<QUEUE_NUMBER>
     */
    public static function generateReferenceNumber($type = ''): string
    {
        $today = now()->format('mdy');
        $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
        
        // Create certificate type code based on type
        $typeCode = self::getCertificateTypeCode($type);
        
        return 'CERT_' . $typeCode . '_' . $today . '_' . str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Map certificate type to specific code
     */
    private static function getCertificateTypeCode($type)
    {
        $codeMap = [
            'barangay_clearance' => 'BARCLE',
            'certificate_of_indigency' => 'CERIND',
            'certificate_of_residency' => 'CERRES',
            'business_permit' => 'BUSPEM',
            'community_tax_certificate' => 'COMTAX',
            'other' => 'OTHER',
        ];
        
        return $codeMap[$type] ?? strtoupper(substr(str_replace(['_', ' '], '', $type), 0, 6));
    }
}
