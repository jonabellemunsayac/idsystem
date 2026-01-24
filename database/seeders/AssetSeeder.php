<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Furniture',
            'Equipment',
            'Office Supplies',
            'Vehicles',
            'Electronics',
            'Tools',
            'Sports Equipment',
            'Communication Devices',
            'Disaster Equipment',
            'Safety Equipment'
        ];

        $statuses = ['working', 'maintenance', 'disposal', 'inactive'];
        
        $assetNames = [
            'Office Chair', 'Conference Table', 'Desk Lamp', 'Filing Cabinet',
            'Computer CPU', 'Monitor', 'Printer', 'Scanner', 'Keyboard', 'Mouse',
            'Motorcycle', 'Vehicle Tire', 'Engine Oil', 'Battery',
            'First Aid Kit', 'Fire Extinguisher', 'Safety Vest', 'Helmet',
            'Microphone', 'Amplifier', 'Speaker System', 'Projector',
            'Soccer Ball', 'Basketball', 'Volleyball', 'Badminton Set',
            'Hand Drill', 'Hammer', 'Saw', 'Measuring Tape',
            'Radio', 'Walkie Talkie', 'Mobile Phone', 'Telephone',
            'Tent', 'Cot Bed', 'Blanket', 'Rope',
            'Ladder', 'Wheelchair', 'Stretcher', 'Oxygen Tank'
        ];

        $locations = [
            'Barangay Hall',
            'Storage Room 1',
            'Storage Room 2',
            'Office A',
            'Office B',
            'Community Center',
            'Sports Court',
            'Maintenance Area',
            'Emergency Room',
            'Reception Area'
        ];

        $descriptions = [
            'General office use',
            'Community services',
            'Emergency purposes',
            'Administrative use',
            'Community programs',
            'Maintenance and repairs',
            'Public safety',
            'Health and wellness',
            'Education and training',
            'Infrastructure support'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $category = $categories[array_rand($categories)];
            $status = $statuses[array_rand($statuses)];
            $assetName = $assetNames[array_rand($assetNames)];
            $location = $locations[array_rand($locations)];
            $description = $descriptions[array_rand($descriptions)];
            
            // Generate random acquisition date within the last 5 years
            $daysOffset = rand(-1825, 0);
            $acquisitionDate = Carbon::now()->addDays($daysOffset)->toDateString();
            
            // Generate last maintenance date if status requires it
            $lastMaintenanceDate = null;
            if (in_array($status, ['maintenance', 'working'])) {
                $daysOffsetMaint = rand(-90, 0);
                $lastMaintenanceDate = Carbon::now()->addDays($daysOffsetMaint)->toDateString();
            }

            Asset::create([
                'asset_name' => $assetName . ' #' . $i,
                'category' => $category,
                'quantity' => rand(1, 20),
                'acquisition_date' => $acquisitionDate,
                'status' => $status,
                'last_maintenance_date' => $lastMaintenanceDate,
                'description' => $description,
                'location' => $location,
            ]);
        }

        $this->command->info('100 assets seeded successfully.');
    }
}
