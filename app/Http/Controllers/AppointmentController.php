<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Certificate;
use App\Models\Resident;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('resident');

        if ($search = $request->input('search')) {
            $query->whereHas('resident', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('scheduled_time', 'desc')
            ->paginate(3)
            ->through(fn($apt) => [
                'id' => $apt->id,
                'resident_id' => $apt->resident_id,
                'resident_name' => $apt->resident->first_name . ' ' . $apt->resident->last_name,
                'appointment_date' => $apt->scheduled_time,
                'status' => $apt->status,
                'purpose' => $apt->purpose ?? 'Certificate Request',
                'reference_number' => $apt->reference_number,
                'notes' => $apt->notes,
                'created_at' => $apt->created_at,
            ])
            ->withQueryString();

        // Get all appointments for calendar display (not paginated)
        $allAppointments = Appointment::with('resident')
            ->orderBy('scheduled_time', 'desc')
            ->get()
            ->map(fn($apt) => [
                'id' => $apt->id,
                'appointment_date' => $apt->scheduled_time,
                'reference_number' => $apt->reference_number,
                'resident_name' => $apt->resident->first_name . ' ' . $apt->resident->last_name,
            ]);

        // Fetch certificate requests for the certificates tab
        $certificates = Certificate::with('resident')
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->through(fn($cert) => [
                'id' => $cert->id,
                'resident_id' => $cert->resident_id,
                'resident_name' => $cert->resident->first_name . ' ' . $cert->resident->last_name,
                'type' => $cert->type,
                'status' => $cert->status,
                'reference_number' => $cert->reference_number,
                'purpose' => $cert->purpose,
                'approved_date' => $cert->approved_date,
                'released_date' => $cert->released_date,
                'created_at' => $cert->created_at,
            ])
            ->withQueryString();

        // Get all certificates for calendar display (not paginated)
        $allCertificates = Certificate::with('resident')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($cert) => [
                'id' => $cert->id,
                'created_date' => $cert->created_at,
                'reference_number' => $cert->reference_number,
                'resident_name' => $cert->resident->first_name . ' ' . $cert->resident->last_name,
            ]);

        return view('appointments.index', [
            'appointments' => $appointments,
            'allAppointments' => $allAppointments,
            'certificates' => $certificates,
            'allCertificates' => $allCertificates
        ]);
    }

    public function create()
    {
        $residents = Resident::all()->map(fn($r) => [
            'id' => $r->id,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
        ])->toArray();

        return view('appointments.create', ['residents' => $residents]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => ['required', 'exists:residents,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Get resident for reference number
        $resident = Resident::find($validated['resident_id']);
        $residentInitials = strtoupper(substr($resident->first_name . $resident->last_name, 0, 3));
        $dateCode = \Carbon\Carbon::parse($validated['appointment_date'])->format('mdy');
        $referenceNumber = 'APT_' . $residentInitials . '_' . $dateCode . '_' . str_pad(Appointment::count() + 1, 2, '0', STR_PAD_LEFT);

        $data = array_merge($validated, [
            'scheduled_time' => $validated['appointment_date'],
            'service_type' => 'General Appointment',
            'reference_number' => $referenceNumber,
        ]);
        unset($data['appointment_date']);

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully!');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', [
            'appointment' => [
                'id' => $appointment->id,
                'resident_id' => $appointment->resident_id,
                'resident_name' => $appointment->resident->first_name . ' ' . $appointment->resident->last_name,
                'appointment_date' => $appointment->scheduled_time,
                'reference_number' => $appointment->reference_number,
                'purpose' => $appointment->purpose ?? 'Certificate Request',
                'status' => $appointment->status,
                'notes' => $appointment->notes,
                'created_at' => $appointment->created_at,
            ]
        ]);
    }

    public function edit(Appointment $appointment)
    {
        $residents = Resident::all()->map(fn($r) => [
            'id' => $r->id,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
        ])->toArray();

        return view('appointments.edit', [
            'appointment' => [
                'id' => $appointment->id,
                'resident_id' => $appointment->resident_id,
                'appointment_date' => $appointment->scheduled_time,
                'status' => $appointment->status,
                'notes' => $appointment->notes,
            ],
            'residents' => $residents
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'resident_id' => ['required', 'exists:residents,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $data = array_merge($validated, [
            'scheduled_time' => $validated['appointment_date'],
        ]);
        unset($data['appointment_date']);

        $appointment->update($data);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }

    public function approve(Appointment $appointment)
    {
        try {
            $appointment->update([
                'status' => 'approved'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment approved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get all appointments for the authenticated resident
     */
    public function apiIndex()
    {
        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        $resident = $residentAccount->resident;

        $appointments = Appointment::where('resident_id', $resident->id)
            ->orderBy('scheduled_time', 'desc')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'resident_id' => $appointment->resident_id,
                    'service_type' => $appointment->service_type,
                    'reference_number' => $appointment->reference_number,
                    'scheduled_time' => $appointment->scheduled_time,
                    'date' => $appointment->scheduled_time->format('Y-m-d'),
                    'time' => $appointment->scheduled_time->format('h:i A'),
                    'status' => $appointment->status,
                    'created_at' => $appointment->created_at,
                    'updated_at' => $appointment->updated_at,
                ];
            });

        return response()->json($appointments);
    }

    /**
     * API: Show a specific appointment
     */
    public function apiShow($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verify the appointment belongs to the authenticated resident
        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        if ($appointment->resident_id !== $residentAccount->resident->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'id' => $appointment->id,
            'resident_id' => $appointment->resident_id,
            'service_type' => $appointment->service_type,
            'reference_number' => $appointment->reference_number,
            'scheduled_time' => $appointment->scheduled_time,
            'date' => $appointment->scheduled_time->format('Y-m-d'),
            'time' => $appointment->scheduled_time->format('h:i A'),
            'status' => $appointment->status,
            'notes' => $appointment->notes,
            'created_at' => $appointment->created_at,
            'updated_at' => $appointment->updated_at,
        ]);
    }

    /**
     * API: Create a new appointment for resident
     */
    public function apiStore(Request $request)
    {
        try {
            \Log::info('Appointment creation request:', $request->all());

            $validated = $request->validate([
                'service_type' => 'required|string|max:255',
                'scheduled_time' => 'required|date_format:Y-m-d H:i|after_or_equal:today',
            ], [
                'scheduled_time.after_or_equal' => 'The appointment date must be today or in the future.',
                'scheduled_time.date_format' => 'The appointment date format is invalid (Y-m-d H:i)',
                'service_type.required' => 'Please select a service type.',
            ]);

            $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
            
            if (!$residentAccount) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            $resident = $residentAccount->resident;

            $appointment = Appointment::create([
                'resident_id' => $resident->id,
                'service_type' => $validated['service_type'],
                'scheduled_time' => $validated['scheduled_time'],
                'reference_number' => Appointment::generateReferenceNumber($validated['service_type']),
                'status' => 'pending',
            ]);

            return response()->json([
                'id' => $appointment->id,
                'resident_id' => $appointment->resident_id,
                'service_type' => $appointment->service_type,
                'reference_number' => $appointment->reference_number,
                'scheduled_time' => $appointment->scheduled_time,
                'date' => $appointment->scheduled_time->format('Y-m-d'),
                'time' => $appointment->scheduled_time->format('h:i A'),
                'status' => $appointment->status,
                'created_at' => $appointment->created_at,
                'updated_at' => $appointment->updated_at,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', $e->errors());
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please check your input and try again',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Appointment creation error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Update an appointment
     */
    public function apiUpdate(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verify the appointment belongs to the authenticated resident
        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        if ($appointment->resident_id !== $residentAccount->resident->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'service_type' => 'sometimes|string|max:255',
            'scheduled_time' => 'sometimes|date_format:Y-m-d H:i|after:now',
            'status' => 'sometimes|string|in:pending,approved,completed,cancelled,processing,ready,released',
        ]);

        $appointment->update($validated);

        return response()->json([
            'id' => $appointment->id,
            'resident_id' => $appointment->resident_id,
            'service_type' => $appointment->service_type,
            'reference_number' => $appointment->reference_number,
            'scheduled_time' => $appointment->scheduled_time,
            'date' => $appointment->scheduled_time->format('Y-m-d'),
            'time' => $appointment->scheduled_time->format('h:i A'),
            'status' => $appointment->status,
            'created_at' => $appointment->created_at,
            'updated_at' => $appointment->updated_at,
        ]);
    }

    /**
     * API: Delete an appointment
     */
    public function apiDestroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verify the appointment belongs to the authenticated resident
        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        if ($appointment->resident_id !== $residentAccount->resident->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
