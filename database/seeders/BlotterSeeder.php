<?php

namespace Database\Seeders;

use App\Models\BlotterRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlotterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incidentTypes = [
            'noise-complaint',
            'property-dispute',
            'theft',
            'vandalism',
            'assault',
            'trespassing',
            'disturbance',
            'illegal-construction',
            'waste-disposal',
            'animal-complaint'
        ];

        $severities = ['low', 'medium', 'high', 'critical'];
        $statuses = ['pending', 'investigating', 'resolved'];
        
        $complainantNames = [
            'Juan Santos', 'Maria Cruz', 'Pedro Reyes', 'Ana Torres', 'Carlos Lim',
            'Rosa Garcia', 'Miguel Lopez', 'Isabel Ramos', 'Antonio Diaz', 'lucia Fernandez',
            'Roberto Silva', 'Carmen Morales', 'Francisco Gutierrez', 'Dolores Castro', 'Manuel Romero'
        ];

        $locations = [
            'Roxas Street', 'Osmena Avenue', 'Del Pilar Road', 'Makati Highway',
            'BGY Hall', 'Community Center', 'Basketball Court', 'Public Market',
            'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Main Road',
            'Residential Area', 'Commercial District'
        ];

        $descriptions = [
            'Loud music and noise from residential unit',
            'Boundary dispute with neighbor regarding property line',
            'Stolen mobile phone reported by resident',
            'Building walls defaced with graffiti',
            'Altercation between two neighbors',
            'Unauthorized person found in property',
            'Disorderly conduct in public area',
            'Illegal construction without permit',
            'Improper waste disposal in public area',
            'Stray dogs causing disturbance'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $caseNumber = 'BLT-' . Carbon::now()->format('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $incidentType = $incidentTypes[array_rand($incidentTypes)];
            $severity = $severities[array_rand($severities)];
            $status = $statuses[array_rand($statuses)];
            $complainant = $complainantNames[array_rand($complainantNames)];
            $location = $locations[array_rand($locations)];
            $description = $descriptions[array_rand($descriptions)];
            
            // Generate random date within the last 6 months
            $daysOffset = rand(-180, 0);
            $incidentDate = Carbon::now()->addDays($daysOffset);

            BlotterRecord::create([
                'case_number' => $caseNumber,
                'complainant_name' => $complainant,
                'complainant_contact' => '09' . rand(100000000, 999999999),
                'respondent_name' => $complainantNames[array_rand($complainantNames)],
                'respondent_contact' => '09' . rand(100000000, 999999999),
                'incident_type' => $incidentType,
                'incident_location' => $location,
                'details' => $description,
                'incident_date' => $incidentDate,
                'severity' => $severity,
                'status' => $status,
                'witnesses' => rand(0, 5),
                'notes' => 'Case #' . $i . ' - ' . ucfirst($status) . ' status',
            ]);
        }

        $this->command->info('100 blotter records seeded successfully.');
    }
}
