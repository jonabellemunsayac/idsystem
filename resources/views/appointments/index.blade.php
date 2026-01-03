@extends('layouts.app')

@section('title', 'Appointments')

@section('extra-styles')
    {{-- Styles are loaded from list-views.css --}}
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Appointment & Certificate System</h1>
        <p class="text-muted mb-0">Manage and schedule resident appointments and certificates</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg me-1"></i> New Appointment
    </a>
</div>

<!-- Tabs -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-2 bg-light rounded">
        <ul class="nav nav-pills nav-fill" role="tablist" style="gap: 0.5rem;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-dark bg-white shadow-sm py-2" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab" aria-selected="true">Appointments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-muted py-2" id="certificates-tab" data-bs-toggle="tab" data-bs-target="#certificates" type="button" role="tab" aria-selected="false">Certificates</button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="appointmentsTabContent">
    <!-- Appointments Tab -->
    <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
        <div class="row g-4">
            <!-- Appointment Schedule List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-check text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Appointment Schedule</h5>
                </div>
                <span class="text-muted">Total: {{ $appointments->count() }}</span>
            </div>
            <div class="card-body p-4 d-flex flex-column" style="min-height: 500px;">
                <div class="d-flex flex-column gap-3 flex-grow-1">
                    @if($appointments->total() == 0)
                        <!-- Mock Data for Preview if Empty -->
                        <div class="card border rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0 text-dark fs-6">sakyo world</h6>
                                        <span class="badge bg-warning text-dark rounded-pill px-3">pending</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-file-text"></i>
                                        <span>Certificate of Residency</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-calendar"></i>
                                        <span>2025-12-30</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-clock"></i>
                                        <span>10:00 AM</span>
                                    </div>
                                    <div class="text-primary mt-2 small">
                                        Ref: APT_CERRES_122825_01
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                    <button class="btn btn-outline-secondary btn-sm">Details</button>
                                    <button class="btn btn-success btn-sm text-white approve-btn" data-appointment-id="1" style="background-color: #198754;">Approve</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0 text-dark fs-6">test asd</h6>
                                        <span class="badge bg-success rounded-pill px-3">approved</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-file-text"></i>
                                        <span>Certificate of Indigency</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-calendar"></i>
                                        <span>2025-12-31</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-clock"></i>
                                        <span>02:00 PM</span>
                                    </div>
                                    <div class="text-primary mt-2 small">
                                        Ref: APT_CERIND_122325_04
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                    <button class="btn btn-outline-secondary btn-sm">Details</button>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($appointments as $appointment)
                        <div class="card border rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0 text-dark fs-6">{{ $appointment['resident_name'] ?? 'Resident Name' }}</h6>
                                        @if($appointment['status'] == 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">pending</span>
                                        @elseif($appointment['status'] == 'approved')
                                            <span class="badge bg-success rounded-pill px-3">approved</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ $appointment['status'] }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-file-text"></i>
                                        <span>{{ $appointment['purpose'] ?? 'Certificate Request' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('h:i A') }}</span>
                                    </div>
                                    <div class="text-primary mt-2 small">
                                        Ref: APT_{{ strtoupper(substr($appointment['resident_name'] ?? 'RES', 0, 3)) }}_{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('mdy') }}_0{{ $loop->iteration }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                    <a href="{{ route('appointments.show', $appointment['id']) }}" class="btn btn-outline-secondary btn-sm">Details</a>
                                    @if($appointment['status'] == 'pending')
                                        <button class="btn btn-success btn-sm text-white approve-btn" data-appointment-id="{{ $appointment['id'] }}" style="background-color: #198754;">Approve</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <!-- Pagination - Always Visible -->
                @if($appointments->total() > 0)
                <div class="mt-auto pt-3 border-top bg-light" style="margin-left: -1rem; margin-right: -1rem; margin-bottom: -1rem; padding-left: 1rem; padding-right: 1rem; padding-bottom: 1rem;">
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        @for($i = 1; $i <= $appointments->lastPage(); $i++)
                            @if($i == $appointments->currentPage())
                                <button class="btn btn-primary btn-sm" disabled style="min-width: 40px;">{{ $i }}</button>
                            @else
                                <a href="{{ $appointments->url($i) }}" class="btn btn-outline-secondary btn-sm" style="min-width: 40px;">{{ $i }}</a>
                            @endif
                        @endfor
                    </div>
                </div>
                @endif
                </div>
            </div>
            </div>

            <!-- Calendar -->
            <div class="col-lg-4">
                @php
                    // Group appointments by date for calendar display
                    $appointmentsByDate = [];
                    foreach($allAppointments as $apt) {
                        $date = \Carbon\Carbon::parse($apt['appointment_date'])->format('Y-m-d');
                        if (!isset($appointmentsByDate[$date])) {
                            $appointmentsByDate[$date] = [];
                        }
                        $appointmentsByDate[$date][] = $apt['reference_number'];
                    }
                    
                    // Get year and month from request or use current date
                    $calendarYear = request('year', \Carbon\Carbon::now()->year);
                    $calendarMonth = request('month', \Carbon\Carbon::now()->month);
                    
                    // Generate calendar for selected month
                    $currentDate = \Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, 1);
                    $year = $currentDate->year;
                    $month = $currentDate->month;
                    $monthName = $currentDate->format('F Y');
                    
                    // Calculate previous and next month URLs
                    $prevMonth = $currentDate->copy()->subMonth();
                    $nextMonth = $currentDate->copy()->addMonth();
                    $prevUrl = route('appointments.index', ['year' => $prevMonth->year, 'month' => $prevMonth->month]);
                    $nextUrl = route('appointments.index', ['year' => $nextMonth->year, 'month' => $nextMonth->month]);
                    
                    // Get first day of month and number of days
                    $firstDay = \Carbon\Carbon::createFromDate($year, $month, 1);
                    $daysInMonth = $firstDay->daysInMonth;
                    $startingDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday, 6 = Saturday
                    
                    $calendarDays = [];
                    $dayCounter = 1;
                    
                    // Fill in the calendar grid
                    for ($week = 0; $week < 6; $week++) {
                        for ($day = 0; $day < 7; $day++) {
                            $cellDate = null;
                            $isCurrentMonth = false;
                            
                            if ($week === 0 && $day < $startingDayOfWeek) {
                                // Previous month days
                                $prevDate = $firstDay->copy()->subDays($startingDayOfWeek - $day);
                                $cellDate = $prevDate->format('Y-m-d');
                                $dayNumber = $prevDate->day;
                            } elseif ($dayCounter <= $daysInMonth) {
                                // Current month days
                                $cellDate = \Carbon\Carbon::createFromDate($year, $month, $dayCounter)->format('Y-m-d');
                                $dayNumber = $dayCounter;
                                $isCurrentMonth = true;
                                $dayCounter++;
                            } else {
                                // Next month days
                                $nextDate = \Carbon\Carbon::createFromDate($year, $month, $daysInMonth)->copy()->addDays($dayCounter - $daysInMonth);
                                $cellDate = $nextDate->format('Y-m-d');
                                $dayNumber = $nextDate->day;
                                $dayCounter++;
                            }
                            
                            $calendarDays[] = [
                                'date' => $cellDate,
                                'day' => $dayNumber,
                                'isCurrentMonth' => $isCurrentMonth
                            ];
                        }
                    }
                @endphp
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $monthName }}</h6>
                            <div class="d-flex gap-1">
                                <a href="{{ $prevUrl }}" class="btn btn-light btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.7rem;"><i class="bi bi-chevron-left"></i></a>
                                <a href="{{ $nextUrl }}" class="btn btn-light btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.7rem;"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        
                        <table class="table table-borderless table-sm text-center mb-0" style="font-size: 0.7rem;">
                                <thead>
                                    <tr>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Sun</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Mon</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Tue</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Wed</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Thu</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Fri</th>
                                        <th class="text-muted fw-normal p-1" style="width: 14.28%; font-size: 0.65rem;">Sat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $dayIndex = 0; @endphp
                                    @for ($week = 0; $week < 6; $week++)
                                        <tr>
                                            @for ($day = 0; $day < 7; $day++)
                                                @php
                                                    $cellData = $calendarDays[$dayIndex];
                                                    $cellDate = $cellData['date'];
                                                    $dayNumber = $cellData['day'];
                                                    $isCurrentMonth = $cellData['isCurrentMonth'];
                                                    $dayIndex++;
                                                    
                                                    $hasAppointments = isset($appointmentsByDate[$cellDate]);
                                                    $references = $hasAppointments ? $appointmentsByDate[$cellDate] : [];
                                                    $tooltip = implode(PHP_EOL, $references);
                                                    $isToday = $cellDate === now()->format('Y-m-d');
                                                @endphp
                                                
                                                @if(!$isCurrentMonth)
                                                    <td class="py-2 px-1 text-muted opacity-25" title="">{{ $dayNumber }}</td>
                                                @elseif($isToday)
                                                    <td class="py-2 px-1 position-relative" title="{{ $tooltip }}">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 22px; height: 22px; font-size: 0.65rem;">
                                                            <span class="fw-bold">{{ $dayNumber }}</span>
                                                        </div>
                                                        @if($hasAppointments)
                                                        <div class="position-absolute bottom-0 start-50 translate-middle-x" style="margin-bottom: 2px;">
                                                            <div class="bg-primary rounded-circle" style="width: 2px; height: 2px;"></div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td class="py-2 px-1 position-relative" title="{{ $tooltip }}">
                                                        @if($hasAppointments)
                                                            <span class="fw-bold text-primary">{{ $dayNumber }}</span>
                                                            <div class="position-absolute bottom-0 start-50 translate-middle-x" style="margin-bottom: 2px;">
                                                                <div class="bg-primary rounded-circle" style="width: 2px; height: 2px;"></div>
                                                            </div>
                                                        @else
                                                            <span>{{ $dayNumber }}</span>
                                                        @endif
                                                    </td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates Tab -->
    <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="certificates-tab">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-certificate text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Issued Certificates</h5>
                </div>
                <span class="text-muted">Total: 0</span>
            </div>
            <div class="card-body p-4 text-center text-muted">
                <p class="mb-0">No certificates issued yet.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const appointmentId = this.getAttribute('data-appointment-id');
            
            Swal.fire({
                title: 'Confirm Approval',
                text: 'Are you sure you want to approve this appointment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0038A8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make AJAX call to approve appointment
                    fetch(`/appointments/${appointmentId}/approve`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Appointment has been approved successfully.',
                                icon: 'success',
                                confirmButtonColor: '#0038A8'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to approve appointment.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while approving the appointment. Please try again.', 'error');
                    });
                }
            });
        });
    });
</script>
@endsection
