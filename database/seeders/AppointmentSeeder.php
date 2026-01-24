<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::all();
        
        if ($residents->isEmpty()) {
            $this->command->warn('No residents found. Please seed residents first.');
            return;
        }

        $services = ['Business Permit', 'Barangay Certificate', 'Barangay ID', 'Clearance', 'Job Seeking', 'Residency'];
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        for ($i = 1; $i <= 100; $i++) {
            $resident = $residents->random();
            $serviceType = $services[array_rand($services)];
            $status = $statuses[array_rand($statuses)];
            
            // Generate random date within the last 60 days or next 30 days
            $daysOffset = rand(-60, 30);
            $scheduledTime = Carbon::now()->addDays($daysOffset)->setHour(rand(8, 16))->setMinute(0)->setSecond(0);

            Appointment::create([
                'resident_id' => $resident->id,
                'service_type' => $serviceType,
                'reference_number' => 'APT_' . strtoupper(substr($serviceType, 0, 3)) . '_' . Carbon::now()->format('mdy') . '_' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'scheduled_time' => $scheduledTime,
                'status' => $status,
            ]);
        }

        $this->command->info('100 appointments seeded successfully.');
    }
}
