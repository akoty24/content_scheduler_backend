<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('platforms')->insert([
            [
                'name' => 'X (Twitter)',
                'type' => 'twitter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Instagram',
                'type' => 'instagram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LinkedIn',
                'type' => 'linkedin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
