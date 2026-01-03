<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ResidentPortalController extends Controller
{
    /**
     * Get resident and account data
     */
    private function getResidentData()
    {
        $residentAccount = auth('resident')->user();
        $resident = $residentAccount->resident;

        return [
            'resident' => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
                'gender' => $resident->gender,
                'birth_date' => $resident->birth_date,
                'age' => $resident->birth_date ? Carbon::parse($resident->birth_date)->age : null,
                'civil_status' => $resident->civil_status,
                'nationality' => $resident->nationality,
                'barangay' => $resident->barangay,
                'address' => $resident->address,
                'contact_number' => $resident->contact_number,
                'email' => $resident->email,
                'profile_image' => $resident->profile_image,
                'blood_type' => $resident->blood_type,
                'emergency_contact_name' => $resident->emergency_contact_name,
                'emergency_contact_no' => $resident->emergency_contact_no,
                'created_at' => $resident->created_at,
            ],
            'account' => [
                'id' => $residentAccount->id,
                'username' => $residentAccount->username,
                'email' => $residentAccount->email,
                'qr_token' => $residentAccount->qr_token,
            ],
        ];
    }

    /**
     * Show resident dashboard
     */
    public function dashboard()
    {
        $data = $this->getResidentData();
        return view('residents-portal.dashboard', $data);
    }

    /**
     * Show resident profile page
     */
    public function profile()
    {
        $data = $this->getResidentData();
        return view('residents-portal.profile', $data);
    }

    /**
     * Show resident appointments page
     */
    public function appointments()
    {
        $data = $this->getResidentData();
        return view('residents-portal.appointments', $data);
    }

    /**
     * Show resident certificates page
     */
    public function certificates()
    {
        $data = $this->getResidentData();
        return view('residents-portal.certificates', $data);
    }

    /**
     * Show resident family page
     */
    public function family()
    {
        $data = $this->getResidentData();
        return view('residents-portal.family', $data);
    }

    /**
     * Show request certificate page
     */
    public function requestCertificate()
    {
        $data = $this->getResidentData();
        return view('residents-portal.request-certificate', $data);
    }

    /**
     * Show book appointment page
     */
    public function bookAppointment()
    {
        $data = $this->getResidentData();
        return view('residents-portal.book-appointment', $data);
    }
}

