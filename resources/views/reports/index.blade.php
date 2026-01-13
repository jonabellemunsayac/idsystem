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

<!-- Dashboard Statistics Cards -->
<div class="row g-4 mb-4" id="statsContainer">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Total Residents</p>
                        <h3 class="fw-bold mb-0 text-dark" id="totalResidents">0</h3>
                    </div>
                    <i class="bi bi-people-fill text-primary fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Blotter Cases</p>
                        <h3 class="fw-bold mb-0 text-dark" id="totalCases">0</h3>
                    </div>
                    <i class="bi bi-file-text-fill text-warning fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Appointments</p>
                        <h3 class="fw-bold mb-0 text-dark" id="totalAppointments">0</h3>
                    </div>
                    <i class="bi bi-calendar-event-fill text-success fs-5"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Assets</p>
                        <h3 class="fw-bold mb-0 text-dark" id="totalAssets">0</h3>
                    </div>
                    <i class="bi bi-box-seam-fill text-info fs-5"></i>
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <!-- Case Status Overview -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-pie-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Case Status Overview</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="caseStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Status Overview -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-pie-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Asset Status Overview</h5>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="assetStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Cases Trend -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-graph-up text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Monthly Cases Trend</h5>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="caseTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
    let charts = {};

    // Load dashboard statistics
    function loadDashboardStats() {
        fetch('/api/reports/dashboard-stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalResidents').textContent = data.residents;
                document.getElementById('totalCases').textContent = data.blotterCases;
                document.getElementById('totalAppointments').textContent = data.appointments;
                document.getElementById('totalAssets').textContent = data.assets;
            })
            .catch(error => console.error('Error loading dashboard stats:', error));
    }
    // Load demographic statistics
    function loadDemographicStats() {
        fetch('/api/reports/demographic-stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('pwdCount').textContent = data.pwd || 0;
                document.getElementById('seniorCitizenCount').textContent = data.seniorCitizen || 0;
                document.getElementById('soloParentCount').textContent = data.soloParent || 0;
                document.getElementById('femaleCount').textContent = data.female || 0;
                document.getElementById('maleCount').textContent = data.male || 0;
            })
            .catch(error => console.error('Error loading demographic stats:', error));
    }
    // Load case status chart
    function loadCaseStatusChart() {
        fetch('/api/reports/blotter')
            .then(response => response.json())
            .then(data => {
                const labels = data.status.map(item => item.status);
                const counts = data.status.map(item => item.count);
                
                const ctx = document.getElementById('caseStatusChart').getContext('2d');
                if (charts.caseStatus) charts.caseStatus.destroy();
                charts.caseStatus = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: ['#ffc107', '#0038A8', '#28a745'],
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
            .catch(error => console.error('Error loading case status chart:', error));
    }

    // Load asset status chart
    function loadAssetStatusChart() {
        fetch('/api/reports/assets')
            .then(response => response.json())
            .then(data => {
                const labels = data.status.map(item => item.status);
                const counts = data.status.map(item => item.count);
                
                const ctx = document.getElementById('assetStatusChart').getContext('2d');
                if (charts.assetStatus) charts.assetStatus.destroy();
                charts.assetStatus = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
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
            .catch(error => console.error('Error loading asset status chart:', error));
    }

    // Load case trend chart
    function loadCaseTrendChart() {
        fetch('/api/reports/blotter')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('caseTrendChart').getContext('2d');
                if (charts.caseTrend) charts.caseTrend.destroy();
                charts.caseTrend = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.months,
                        datasets: [{
                            label: 'Monthly Cases',
                            data: data.monthlyData,
                            borderColor: '#CE1126',
                            backgroundColor: 'rgba(206, 17, 38, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: '#CE1126'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading case trend chart:', error));
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
        loadDashboardStats();
        loadDemographicStats();
        loadCaseStatusChart();
        loadAssetStatusChart();
        loadCaseTrendChart();
    });

    // Refresh charts every 30 seconds
    setInterval(function() {
        loadDashboardStats();
        loadDemographicStats();
        loadCaseStatusChart();
        loadAssetStatusChart();
        loadCaseTrendChart();
    }, 30000);
</script>
@endsection