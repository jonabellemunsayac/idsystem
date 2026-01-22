@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Reports & Analytics</h1>
        <p class="text-muted mb-0">View system statistics and insights</p>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;" onclick="exportReport('pdf')">
            <i class="bi bi-download me-2"></i> Export Report
        </button>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem;" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" onclick="exportReport('pdf'); return false;">
                <i class="bi bi-file-earmark-pdf text-danger"></i> Export as PDF
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportReport('excel'); return false;">
                <i class="bi bi-file-earmark-excel text-success"></i> Export as Excel
            </a></li>
        </ul>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-funnel text-primary"></i>
            <h6 class="fw-bold mb-0 text-dark">Filters</h6>
        </div>
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">Gender</label>
                <select class="form-select form-select-sm" id="filterGender">
                    <option value="">All</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">Special Sector</label>
                <select class="form-select form-select-sm" id="filterSpecialSector">
                    <option value="">All</option>
                    <option value="Senior Citizen">Senior Citizen</option>
                    <option value="PWD">PWD</option>
                    <option value="Solo Parent">Solo Parent</option>
                    <option value="LGBTQ">LGBTQ</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">Age Group</label>
                <select class="form-select form-select-sm" id="filterAgeGroup">
                    <option value="">All</option>
                    <option value="children">Children (0-17)</option>
                    <option value="adult">Adult (18-59)</option>
                    <option value="senior">Senior (60+)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted">Street Name</label>
                <select class="form-select form-select-sm" id="filterStreetName">
                    <option value="">All Streets</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary btn-sm w-50" onclick="applyFilters()">
                        <i class="bi bi-funnel-fill me-1"></i> Apply
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm w-50" onclick="resetFilters()">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Demographic Statistics Cards -->
<div class="row g-4 mb-4 mt-2" id="demographicsContainer">
    <div class="col-12">
        <h5 class="fw-bold text-dark mb-3">Demographic Statistics</h5>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">PWD</p>
                        <h4 class="fw-bold mb-0 text-dark" id="pwdCount">0</h4>
                    </div>
                    <i class="bi bi-heart-pulse-fill text-danger fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Senior Citizen</p>
                        <h4 class="fw-bold mb-0 text-dark" id="seniorCitizenCount">0</h4>
                    </div>
                    <i class="bi bi-person-walking text-secondary fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Solo Parent</p>
                        <h4 class="fw-bold mb-0 text-dark" id="soloParentCount">0</h4>
                    </div>
                    <i class="bi bi-person-hearts text-info fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">LGBTQ</p>
                        <h4 class="fw-bold mb-0 text-dark" id="lgbtqCount">0</h4>
                    </div>
                    <i class="bi bi-rainbow text-warning fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Children (0-17)</p>
                        <h4 class="fw-bold mb-0 text-dark" id="childrenCount">0</h4>
                    </div>
                    <i class="bi bi-people text-success fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Female</p>
                        <h4 class="fw-bold mb-0 text-dark" id="femaleCount">0</h4>
                    </div>
                    <i class="bi bi-gender-female text-danger fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Male</p>
                        <h4 class="fw-bold mb-0 text-dark" id="maleCount">0</h4>
                    </div>
                    <i class="bi bi-gender-male text-primary fs-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Gender Distribution -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-pie-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Gender Distribution</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Age Group Distribution -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-pie-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Age Group Distribution</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="ageGroupChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Special Sector Distribution -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-bar-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Special Sector Distribution</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="specialSectorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Street Distribution -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-bar-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Residents by Street</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="streetChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
    let charts = {};
    let currentFilters = {
        gender: '',
        specialSector: '',
        ageGroup: '',
        streetName: ''
    };

    // Load demographic statistics
    function loadDemographicStats() {
        const params = new URLSearchParams(currentFilters);
        fetch(`/api/reports/demographic-stats?${params}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('pwdCount').textContent = data.pwd || 0;
                document.getElementById('seniorCitizenCount').textContent = data.seniorCitizen || 0;
                document.getElementById('soloParentCount').textContent = data.soloParent || 0;
                document.getElementById('lgbtqCount').textContent = data.lgbtq || 0;
                document.getElementById('childrenCount').textContent = data.children || 0;
                document.getElementById('femaleCount').textContent = data.female || 0;
                document.getElementById('maleCount').textContent = data.male || 0;
            })
            .catch(error => console.error('Error loading demographic stats:', error));
    }

    // Load street names for filter dropdown
    function loadStreetNames() {
        fetch('/api/reports/street-names')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('filterStreetName');
                select.innerHTML = '<option value="">All Streets</option>';
                if (data.streets && data.streets.length > 0) {
                    data.streets.forEach(street => {
                        if (street) {
                            select.innerHTML += `<option value="${street}">${street}</option>`;
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading street names:', error));
    }

    // Apply filters
    function applyFilters() {
        currentFilters = {
            gender: document.getElementById('filterGender').value,
            specialSector: document.getElementById('filterSpecialSector').value,
            ageGroup: document.getElementById('filterAgeGroup').value,
            streetName: document.getElementById('filterStreetName').value
        };
        
        loadDemographicStats();
        loadGenderChart();
        loadAgeGroupChart();
        loadSpecialSectorChart();
        loadStreetChart();
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('filterGender').value = '';
        document.getElementById('filterSpecialSector').value = '';
        document.getElementById('filterAgeGroup').value = '';
        document.getElementById('filterStreetName').value = '';
        
        currentFilters = {
            gender: '',
            specialSector: '',
            ageGroup: '',
            streetName: ''
        };
        
        loadDemographicStats();
        loadGenderChart();
        loadAgeGroupChart();
        loadSpecialSectorChart();
        loadStreetChart();
    }

    // Load gender distribution chart
    function loadGenderChart() {
        const params = new URLSearchParams(currentFilters);
        fetch(`/api/reports/gender-distribution?${params}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('genderChart').getContext('2d');
                if (charts.gender) charts.gender.destroy();
                charts.gender = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Male', 'Female'],
                        datasets: [{
                            data: [data.male || 0, data.female || 0],
                            backgroundColor: ['#0038A8', '#CE1126'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading gender chart:', error));
    }

    // Load age group chart
    function loadAgeGroupChart() {
        const params = new URLSearchParams(currentFilters);
        fetch(`/api/reports/age-group-distribution?${params}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('ageGroupChart').getContext('2d');
                if (charts.ageGroup) charts.ageGroup.destroy();
                charts.ageGroup = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Children (0-17)', 'Adult (18-59)', 'Senior (60+)'],
                        datasets: [{
                            data: [data.children || 0, data.adult || 0, data.senior || 0],
                            backgroundColor: ['#28a745', '#ffc107', '#6c757d'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading age group chart:', error));
    }

    // Load special sector chart
    function loadSpecialSectorChart() {
        const params = new URLSearchParams(currentFilters);
        fetch(`/api/reports/special-sector-distribution?${params}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('specialSectorChart').getContext('2d');
                if (charts.specialSector) charts.specialSector.destroy();
                charts.specialSector = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Senior Citizen', 'PWD', 'Solo Parent', 'LGBTQ'],
                        datasets: [{
                            label: 'Count',
                            data: [
                                data.seniorCitizen || 0,
                                data.pwd || 0,
                                data.soloParent || 0,
                                data.lgbtq || 0
                            ],
                            backgroundColor: ['#6c757d', '#dc3545', '#17a2b8', '#ffc107'],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading special sector chart:', error));
    }

    // Load street distribution chart
    function loadStreetChart() {
        const params = new URLSearchParams(currentFilters);
        fetch(`/api/reports/street-distribution?${params}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('streetChart').getContext('2d');
                if (charts.street) charts.street.destroy();
                
                const labels = data.streets ? data.streets.map(s => s.street_name || 'N/A') : [];
                const counts = data.streets ? data.streets.map(s => s.total || 0) : [];
                
                charts.street = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Residents',
                            data: counts,
                            backgroundColor: '#0038A8',
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading street chart:', error));
    }

    // Export report functionality
    function exportReport(format) {
        if (format === 'pdf') {
            window.location.href = '/api/reports/export/pdf';
        } else if (format === 'excel') {
            window.location.href = '/api/reports/export/excel';
        }
    }

    // Load all charts on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadDemographicStats();
        loadStreetNames();
        loadGenderChart();
        loadAgeGroupChart();
        loadSpecialSectorChart();
        loadStreetChart();
    });

    // Refresh charts every 30 seconds
    setInterval(function() {
        loadDemographicStats();
        loadGenderChart();
        loadAgeGroupChart();
        loadSpecialSectorChart();
        loadStreetChart();
    }, 30000);
</script>
@endsection