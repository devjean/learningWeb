<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgeGroup;

class AgeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ageGroups = [
            ['range' => '5-8 años'],
            ['range' => '9-13 años'],
            ['range' => '14-16 años'],
            ['range' => '16+ años'],
        ];

        foreach ($ageGroups as $group) {
            AgeGroup::create($group);
        }
    }
}
