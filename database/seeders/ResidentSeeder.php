<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ResidentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNames = [
            'Juan', 'Maria', 'Jose', 'Anna', 'Roberto', 'Carmen', 'Antonio', 'Rosa',
            'Miguel', 'Lucia', 'Francisco', 'Isabel', 'Diego', 'Elena', 'Carlos', 'Sofia',
            'Luis', 'Magdalena', 'Rodrigo', 'Angela', 'Fernando', 'Catalina', 'Pedro', 'Olivia',
            'Manuel', 'Victoria', 'Raul', 'Gabriela', 'Pablo', 'Adriana', 'Ricardo', 'Beatriz',
            'Enrique', 'Cecilia', 'Javier', 'Dolores', 'Ignacio', 'Esperanza', 'Arturo', 'Mariana',
        ];

        $lastNames = [
            'Santos', 'Cruz', 'Rivera', 'Fernandez', 'Garcia', 'Lopez', 'Martinez', 'Gonzalez',
            'Rodriguez', 'Perez', 'Hernandez', 'Torres', 'Flores', 'Morales', 'Reyes', 'Gutierrez',
            'Castillo', 'Soto', 'Romero', 'Vargas', 'Medina', 'Ramos', 'Mendoza', 'Jimenez',
            'Delgado', 'Santiago', 'Montes', 'Munoz', 'Pena', 'Salazar', 'Caballero', 'Valencia',
            'Figueroa', 'Campos', 'Sanz', 'Miranda', 'Vega', 'Acosta', 'Suarez', 'Chavez',
        ];

        $genders = ['Male', 'Female'];
        $civilStatus = ['Single', 'Married', 'Widowed', 'Separated', 'Divorced'];
        $barangays = [
            'Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5',
            'Barangay 6', 'Barangay 7', 'Barangay 8', 'Barangay 9', 'Barangay 10',
            'Barangay 11', 'Barangay 12', 'Barangay 13', 'Barangay 14', 'Barangay 15',
        ];

        $streets = [
            'Main Street', 'Peace Street', 'Freedom Avenue', 'Unity Road', 'Hope Lane',
            'Progress Drive', 'Development Boulevard', 'Community Way', 'Harmony Street', 'Victory Avenue',
            'Success Road', 'Excellence Lane', 'Innovation Drive', 'Leadership Boulevard', 'Vision Street',
        ];

        $puroks = ['Purok A', 'Purok B', 'Purok C', 'Purok D', 'Purok E'];
        $bloodTypes = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        $specialSectors = ['Senior Citizen', 'PWD', 'Solo Parent', 'Farmer', 'Fisher', 'None'];
        $nationalities = ['Filipino', 'Filipino-American', 'Filipino-Chinese', 'Filipino'];
        
        $relationships = ['Parent', 'Spouse', 'Sibling', 'Child', 'Friend', 'Relative'];

        for ($i = 1; $i <= 100; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $birthDate = Carbon::now()->subYears(rand(18, 80))->subDays(rand(0, 365));
            $gender = $genders[array_rand($genders)];

            Resident::create([
                'first_name' => $firstName,
                'middle_name' => $lastNames[array_rand($lastNames)],
                'last_name' => $lastName,
                'gender' => $gender,
                'birth_date' => $birthDate->format('Y-m-d'),
                'civil_status' => $civilStatus[array_rand($civilStatus)],
                'nationality' => $nationalities[array_rand($nationalities)],
                'special_sector' => $specialSectors[array_rand($specialSectors)],
                'barangay' => $barangays[array_rand($barangays)],
                'house_no' => rand(1, 999),
                'street_name' => $streets[array_rand($streets)],
                'purok' => $puroks[array_rand($puroks)],
                'province' => 'Rizal',
                'zip_code' => '1860',
                'address' => rand(1, 999) . ' ' . $streets[array_rand($streets)] . ', Pasig, Rizal',
                'contact_number' => '09' . rand(10000000, 99999999),
                'telephone_no' => '(02) ' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'email' => strtolower($firstName . '.' . $lastName . rand(100, 999) . '@example.com'),
                'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                'emergency_contact_name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                'emergency_contact_no' => '09' . rand(10000000, 99999999),
                'emergency_contact_relationship' => $relationships[array_rand($relationships)],
                'emergency_contact_address' => rand(1, 999) . ' ' . $streets[array_rand($streets)] . ', Pasig, Rizal',
                'family_id' => null,
                'clan_id' => null,
            ]);
        }

        $this->command->info('100 residents seeded successfully.');
    }
}
