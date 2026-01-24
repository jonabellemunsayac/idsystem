<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Barangay Management System - Reports</title>
</head>
<body>
    <p>This page is no longer used. PDF export is now handled directly on the reports page.</p>
</body>
</html>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0038A8;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            color: #0038A8;
            margin-bottom: 10px;
        }
        
        .header h2 {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .generated-date {
            font-size: 12px;
            color: #999;
            font-style: italic;
        }
        
        .section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #0038A8;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0038A8;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #0038A8;
        }
        
        .stat-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #0038A8;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
        }
        
        th {
            background: #0038A8;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .chart-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .chart-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .demographic-columns {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #999;
            text-align: center;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            .no-break {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div id="pdf-content">
        <!-- Header -->
        <div class="header">
            <h1>BARANGAY MANAGEMENT SYSTEM</h1>
            <h2>Reports & Analytics Dashboard</h2>
            <p class="generated-date">Generated on: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
        </div>

        <!-- General Statistics Section -->
        <div class="section">
            <h3 class="section-title">General Statistics</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Residents</div>
                    <div class="stat-value">{{ $statistics['residents'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Appointments</div>
                    <div class="stat-value">{{ $statistics['appointments'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Blotter Cases</div>
                    <div class="stat-value">{{ $statistics['blotterCases'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Assets</div>
                    <div class="stat-value">{{ $statistics['assets'] }}</div>
                </div>
            </div>
        </div>

        <!-- Demographic Statistics Section -->
        <div class="section">
            <h3 class="section-title">Demographic Statistics</h3>
            <div class="demographic-columns">
                <div class="no-break">
                    <h4 class="chart-title">Special Sectors</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th style="text-align: right;">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PWD</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['pwd'] }}</td>
                            </tr>
                            <tr>
                                <td>Senior Citizen</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['seniorCitizen'] }}</td>
                            </tr>
                            <tr>
                                <td>Solo Parent</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['soloParent'] }}</td>
                            </tr>
                            <tr>
                                <td>LGBTQ</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['lgbtq'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="no-break">
                    <h4 class="chart-title">Gender Distribution</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Gender</th>
                                <th style="text-align: right;">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Male</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['male'] }}</td>
                            </tr>
                            <tr>
                                <td>Female</td>
                                <td style="text-align: right; font-weight: 600;">{{ $statistics['female'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Age Group Distribution Section -->
        <div class="section">
            <h3 class="section-title">Age Group Distribution</h3>
            <table>
                <thead>
                    <tr>
                        <th>Age Group</th>
                        <th style="text-align: right;">Count</th>
                        <th style="text-align: right;">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalResidents = $statistics['residents'];
                        $childrenPct = $totalResidents > 0 ? round(($statistics['children'] / $totalResidents) * 100, 1) : 0;
                        $adultPct = $totalResidents > 0 ? round(($statistics['adult'] / $totalResidents) * 100, 1) : 0;
                        $seniorPct = $totalResidents > 0 ? round(($statistics['senior'] / $totalResidents) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td>Children (0-17)</td>
                        <td style="text-align: right; font-weight: 600;">{{ $statistics['children'] }}</td>
                        <td style="text-align: right;">{{ $childrenPct }}%</td>
                    </tr>
                    <tr>
                        <td>Adult (18-59)</td>
                        <td style="text-align: right; font-weight: 600;">{{ $statistics['adult'] }}</td>
                        <td style="text-align: right;">{{ $adultPct }}%</td>
                    </tr>
                    <tr>
                        <td>Senior (60+)</td>
                        <td style="text-align: right; font-weight: 600;">{{ $statistics['senior'] }}</td>
                        <td style="text-align: right;">{{ $seniorPct }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Civil Status Section -->
        <div class="section">
            <h3 class="section-title">Civil Status Distribution</h3>
            <table>
                <thead>
                    <tr>
                        <th>Civil Status</th>
                        <th style="text-align: right;">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistics['civilStatus'] as $status => $count)
                    <tr>
                        <td>{{ ucfirst($status) }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ $count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated by the Barangay Management System</p>
            <p>For official records and approvals, please sign and stamp the printed copy</p>
        </div>
    </div>

    <script>
        // Auto-generate and download PDF on page load
        window.addEventListener('load', function() {
            const element = document.getElementById('pdf-content');
            const opt = {
                margin: 10,
                filename: 'reports-{{ \Carbon\Carbon::now()->format('Y-m-d') }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            
            // Generate and download PDF
            html2pdf().set(opt).from(element).save();
            
            // Redirect back to reports after 1 second
            setTimeout(function() {
                window.location.href = '/reports';
            }, 1000);
        });
    </script>
</body>
</html>
