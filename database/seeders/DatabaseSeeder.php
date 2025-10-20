<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Patient;
use App\Models\VisitPasscode;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Seed users first
        $this->call(UserSeeder::class);
        
        $wards = ['ICU', 'General', 'Pediatric', 'Emergency'];
        foreach($wards as $w) {
            $ward = Ward::firstOrCreate(
                ['code' => strtoupper(substr($w, 0, 3)) . '1'],
                [
                    'name' => $w . ' Ward',
                    'total_beds' => 8,
                ]
            );
            
            // Only create beds if they don't exist
            if ($ward->beds()->count() == 0) {
                for ($i = 1; $i <= 8; $i++) {
                    Bed::create([
                        'ward_id' => $ward->id,
                        'bed_number' => str_pad($i, 3, '0', STR_PAD_LEFT),
                    ]);
                }
            }
        }
        
        $beds = Bed::inRandomOrder()->take(10)->get();
        foreach($beds as $bed) {
            $p = Patient::factory()->create();
            $bed->update(['patient_id' => $p->id]);
            VisitPasscode::create([
                'patient_id' => $p->id,
                'code' => strtoupper(str()->random(9)),
                'expires_at' => now()->addDays(2),
                'status' => 'active',
            ]);
        }
    }
}
