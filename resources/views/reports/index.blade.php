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
                    <option value="None">None</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">Special Sector</label>
                <select class="form-select form-select-sm" id="filterSpecialSector">
                    <option value="">All</option>
                    <option value="None">None</option>
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
                    <option value="None">None</option>
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
    <div class="col-lg-6" id="genderChartContainer">
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
    <div class="col-lg-6" id="ageGroupChartContainer">
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
    <div class="col-lg-6" id="specialSectorChartContainer">
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
    <div class="col-lg-6" id="streetChartContainer">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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
                select.innerHTML = '<option value="">All Streets</option><option value="None">None</option>';
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

    // Update chart visibility based on selected filters
    function updateChartVisibility() {
        const hasGenderFilter = currentFilters.gender && currentFilters.gender !== '';
        const hasSpecialSectorFilter = currentFilters.specialSector && currentFilters.specialSector !== '';
        const hasAgeGroupFilter = currentFilters.ageGroup && currentFilters.ageGroup !== '';
        const hasStreetNameFilter = currentFilters.streetName && currentFilters.streetName !== '';
        
        // If no filters are selected, show all charts
        const noFiltersSelected = !hasGenderFilter && !hasSpecialSectorFilter && !hasAgeGroupFilter && !hasStreetNameFilter;
        
        // Always show all charts - they will be smart filtered to show relevant data
        // The selected filter's chart will show only that value, others will show full breakdown within that context
        document.getElementById('genderChartContainer').style.display = '';
        document.getElementById('ageGroupChartContainer').style.display = '';
        document.getElementById('specialSectorChartContainer').style.display = '';
        document.getElementById('streetChartContainer').style.display = '';
    }

    // Apply filters
    function applyFilters() {
        currentFilters = {
            gender: document.getElementById('filterGender').value,
            specialSector: document.getElementById('filterSpecialSector').value,
            ageGroup: document.getElementById('filterAgeGroup').value,
            streetName: document.getElementById('filterStreetName').value
        };
        
        // Show/hide charts based on selected filters
        updateChartVisibility();
        
        loadDemographicStats();
        
        // Load all charts - they will show smart filtered data
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
        
        // Show all charts when filters are reset
        updateChartVisibility();
        
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
                
                // If gender filter is selected, show only that gender
                let labels, chartData, colors;
                if (currentFilters.gender && currentFilters.gender !== '') {
                    if (currentFilters.gender === 'Male') {
                        labels = ['Male'];
                        chartData = [data.male || 0];
                        colors = ['#0038A8'];
                    } else if (currentFilters.gender === 'Female') {
                        labels = ['Female'];
                        chartData = [data.female || 0];
                        colors = ['#CE1126'];
                    } else if (currentFilters.gender === 'None') {
                        labels = ['None'];
                        chartData = [data.male || 0]; // Using male as total for None
                        colors = ['#6c757d'];
                    }
                } else {
                    labels = ['Male', 'Female'];
                    chartData = [data.male || 0, data.female || 0];
                    colors = ['#0038A8', '#CE1126'];
                }
                
                charts.gender = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: chartData,
                            backgroundColor: colors,
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
                
                // If age group filter is selected, show only that age group
                let labels, chartData, colors;
                if (currentFilters.ageGroup && currentFilters.ageGroup !== '') {
                    if (currentFilters.ageGroup === 'children') {
                        labels = ['Children (0-17)'];
                        chartData = [data.children || 0];
                        colors = ['#28a745'];
                    } else if (currentFilters.ageGroup === 'adult') {
                        labels = ['Adult (18-59)'];
                        chartData = [data.adult || 0];
                        colors = ['#ffc107'];
                    } else if (currentFilters.ageGroup === 'senior') {
                        labels = ['Senior (60+)'];
                        chartData = [data.senior || 0];
                        colors = ['#6c757d'];
                    } else if (currentFilters.ageGroup === 'None') {
                        labels = ['None'];
                        chartData = [data.children || 0]; // Using children as total for None
                        colors = ['#dc3545'];
                    }
                } else {
                    labels = ['Children (0-17)', 'Adult (18-59)', 'Senior (60+)'];
                    chartData = [data.children || 0, data.adult || 0, data.senior || 0];
                    colors = ['#28a745', '#ffc107', '#6c757d'];
                }
                
                charts.ageGroup = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: chartData,
                            backgroundColor: colors,
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
                
                // If special sector filter is selected, show only that sector
                // Otherwise, show all sectors (filtered by other dimensions if applicable)
                let labels, chartData, colors;
                if (currentFilters.specialSector && currentFilters.specialSector !== '') {
                    // Show only the selected special sector
                    if (currentFilters.specialSector === 'Senior Citizen') {
                        labels = ['Senior Citizen'];
                        chartData = [data.seniorCitizen || 0];
                        colors = ['#6c757d'];
                    } else if (currentFilters.specialSector === 'PWD') {
                        labels = ['PWD'];
                        chartData = [data.pwd || 0];
                        colors = ['#dc3545'];
                    } else if (currentFilters.specialSector === 'Solo Parent') {
                        labels = ['Solo Parent'];
                        chartData = [data.soloParent || 0];
                        colors = ['#17a2b8'];
                    } else if (currentFilters.specialSector === 'LGBTQ') {
                        labels = ['LGBTQ'];
                        chartData = [data.lgbtq || 0];
                        colors = ['#ffc107'];
                    } else if (currentFilters.specialSector === 'None') {
                        labels = ['None'];
                        chartData = [data.none || 0];
                        colors = ['#28a745'];
                    }
                } else {
                    // Show all special sectors breakdown (filtered by other selected dimensions)
                    labels = ['Senior Citizen', 'PWD', 'Solo Parent', 'LGBTQ', 'None'];
                    chartData = [
                        data.seniorCitizen || 0,
                        data.pwd || 0,
                        data.soloParent || 0,
                        data.lgbtq || 0,
                        data.none || 0
                    ];
                    colors = ['#6c757d', '#dc3545', '#17a2b8', '#ffc107', '#28a745'];
                }
                
                charts.specialSector = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Count',
                            data: chartData,
                            backgroundColor: colors,
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
                
                // Adjust chart title based on filters
                let chartLabel = 'Residents';
                if (currentFilters.streetName && currentFilters.streetName !== '') {
                    chartLabel = `Residents in ${currentFilters.streetName}`;
                } else if (currentFilters.ageGroup || currentFilters.specialSector || currentFilters.gender) {
                    // Show what dimensions are filtered
                    let filterParts = [];
                    if (currentFilters.ageGroup) filterParts.push(currentFilters.ageGroup);
                    if (currentFilters.specialSector) filterParts.push(currentFilters.specialSector);
                    if (currentFilters.gender) filterParts.push(currentFilters.gender);
                    if (filterParts.length > 0) {
                        chartLabel = `Residents (${filterParts.join(', ')})`;
                    }
                }
                
                charts.street = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: chartLabel,
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
                                display: true,
                                position: 'top'
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
            // Disable buttons to prevent multiple clicks
            const buttons = document.querySelectorAll('.btn-primary');
            buttons.forEach(btn => btn.disabled = true);
            
            try {
                // Create a new container for PDF content
                const reportContainer = document.createElement('div');
                reportContainer.style.padding = '15px';
                reportContainer.style.backgroundColor = '#fff';
                reportContainer.style.fontFamily = 'Arial, sans-serif';
                reportContainer.style.width = '100%';
                reportContainer.style.maxWidth = '210mm';
                
                // Add title
                const title = document.createElement('h1');
                title.textContent = 'BARANGAY MANAGEMENT SYSTEM';
                title.style.textAlign = 'center';
                title.style.color = '#0038A8';
                title.style.marginBottom = '5px';
                title.style.fontSize = '20px';
                title.style.margin = '0 0 5px 0';
                reportContainer.appendChild(title);
                
                const subtitle = document.createElement('h2');
                subtitle.textContent = 'Reports & Analytics Dashboard';
                subtitle.style.textAlign = 'center';
                subtitle.style.color = '#666';
                subtitle.style.fontSize = '14px';
                subtitle.style.marginBottom = '5px';
                subtitle.style.fontWeight = '600';
                subtitle.style.margin = '0 0 5px 0';
                reportContainer.appendChild(subtitle);
                
                const date = document.createElement('p');
                date.textContent = 'Generated on: ' + new Date().toLocaleString();
                date.style.textAlign = 'center';
                date.style.color = '#999';
                date.style.fontSize = '11px';
                date.style.marginBottom = '20px';
                date.style.margin = '0 0 20px 0';
                reportContainer.appendChild(date);
                
                // Add demographic statistics title
                const statsTitle = document.createElement('h3');
                statsTitle.textContent = 'Demographic Statistics';
                statsTitle.style.color = '#0038A8';
                statsTitle.style.fontSize = '14px';
                statsTitle.style.marginBottom = '15px';
                statsTitle.style.borderBottom = '2px solid #0038A8';
                statsTitle.style.paddingBottom = '8px';
                statsTitle.style.margin = '0 0 15px 0';
                reportContainer.appendChild(statsTitle);
                
                // Add demographic stats cards in single column
                const statsGrid = document.createElement('div');
                statsGrid.style.display = 'grid';
                statsGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
                statsGrid.style.gap = '10px';
                statsGrid.style.marginBottom = '25px';
                
                const demoDivs = document.querySelectorAll('#demographicsContainer .card');
                demoDivs.forEach(card => {
                    const clone = card.cloneNode(true);
                    clone.style.padding = '12px';
                    clone.style.border = '1px solid #ddd';
                    clone.style.borderRadius = '4px';
                    clone.style.fontSize = '11px';
                    statsGrid.appendChild(clone);
                });
                reportContainer.appendChild(statsGrid);
                
                // Add charts section
                const chartsTitle = document.createElement('h3');
                chartsTitle.textContent = 'Charts & Graphs';
                chartsTitle.style.color = '#0038A8';
                chartsTitle.style.fontSize = '14px';
                chartsTitle.style.marginBottom = '15px';
                chartsTitle.style.marginTop = '25px';
                chartsTitle.style.borderBottom = '2px solid #0038A8';
                chartsTitle.style.paddingBottom = '8px';
                chartsTitle.style.margin = '25px 0 15px 0';
                reportContainer.appendChild(chartsTitle);
                
                // Add charts as images - full width layout
                const chartIds = ['genderChart', 'ageGroupChart', 'specialSectorChart', 'streetChart'];
                const chartTitles = ['Gender Distribution', 'Age Group Distribution', 'Special Sector Distribution', 'Residents by Street'];
                
                chartIds.forEach((chartId, index) => {
                    const canvas = document.getElementById(chartId);
                    if (canvas) {
                        const chartDiv = document.createElement('div');
                        chartDiv.style.border = '1px solid #ddd';
                        chartDiv.style.padding = '12px';
                        chartDiv.style.borderRadius = '4px';
                        chartDiv.style.pageBreakInside = 'avoid';
                        chartDiv.style.marginBottom = '15px';
                        chartDiv.style.width = '100%';
                        chartDiv.style.boxSizing = 'border-box';
                        
                        // Alternate between full width and 2-column layout
                        if (index < 2) {
                            // First two charts side by side
                            if (index === 0) {
                                const chartsRow = document.createElement('div');
                                chartsRow.style.display = 'grid';
                                chartsRow.style.gridTemplateColumns = 'repeat(2, 1fr)';
                                chartsRow.style.gap = '15px';
                                chartsRow.style.marginBottom = '15px';
                                
                                // Add Gender chart
                                const genderDiv = createChartDiv(chartIds[0], chartTitles[0]);
                                chartsRow.appendChild(genderDiv);
                                
                                // Add Age Group chart
                                const ageDiv = createChartDiv(chartIds[1], chartTitles[1]);
                                chartsRow.appendChild(ageDiv);
                                
                                reportContainer.appendChild(chartsRow);
                            }
                        } else {
                            // Last two charts full width
                            const chartDiv = createChartDiv(chartId, chartTitles[index]);
                            reportContainer.appendChild(chartDiv);
                        }
                    }
                });
                
                // Helper function to create chart div
                function createChartDiv(chartId, title) {
                    const canvas = document.getElementById(chartId);
                    const chartDiv = document.createElement('div');
                    chartDiv.style.border = '1px solid #ddd';
                    chartDiv.style.padding = '12px';
                    chartDiv.style.borderRadius = '4px';
                    chartDiv.style.pageBreakInside = 'avoid';
                    chartDiv.style.width = '100%';
                    chartDiv.style.boxSizing = 'border-box';
                    
                    const chartTitleEl = document.createElement('h4');
                    chartTitleEl.textContent = title;
                    chartTitleEl.style.fontSize = '12px';
                    chartTitleEl.style.color = '#333';
                    chartTitleEl.style.marginBottom = '10px';
                    chartTitleEl.style.fontWeight = '600';
                    chartTitleEl.style.margin = '0 0 10px 0';
                    chartDiv.appendChild(chartTitleEl);
                    
                    const img = document.createElement('img');
                    img.src = canvas.toDataURL('image/png');
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
                    img.style.display = 'block';
                    chartDiv.appendChild(img);
                    
                    return chartDiv;
                }
                
                // Add footer
                const footer = document.createElement('div');
                footer.style.marginTop = '25px';
                footer.style.paddingTop = '15px';
                footer.style.borderTop = '1px solid #ddd';
                footer.style.fontSize = '10px';
                footer.style.color = '#999';
                footer.style.textAlign = 'center';
                footer.innerHTML = '<p style="margin: 0;">This report was automatically generated by the Barangay Management System</p>';
                reportContainer.appendChild(footer);
                
                // Generate PDF
                const opt = {
                    margin: [10, 8, 10, 8],
                    filename: 'reports-' + new Date().toISOString().split('T')[0] + '.pdf',
                    image: { type: 'jpeg', quality: 0.95 },
                    html2canvas: { scale: 2, useCORS: true, logging: false, allowTaint: true },
                    jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4', compress: true }
                };
                
                html2pdf().set(opt).from(reportContainer).save().then(() => {
                    // Re-enable buttons
                    buttons.forEach(btn => btn.disabled = false);
                }).catch(error => {
                    console.error('PDF generation error:', error);
                    alert('Error generating PDF. Please try again.');
                    buttons.forEach(btn => btn.disabled = false);
                });
            } catch (error) {
                console.error('Export error:', error);
                alert('Error exporting PDF: ' + error.message);
                buttons.forEach(btn => btn.disabled = false);
            }
        } else if (format === 'excel') {
            // Build query string with filters
            const params = new URLSearchParams(currentFilters);
            window.location.href = '/api/reports/export/excel?' + params.toString();
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