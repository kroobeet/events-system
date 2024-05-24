<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Representative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepresentativesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $representativesCount = rand(1, 3);
            Representative::factory()->count($representativesCount)->create([
                'organization_id' => $organization->id,
            ]);
        }
    }
}
