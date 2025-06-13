<?php

namespace Database\Seeders;

use GuzzleHttp\Promise\Create;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Entities\User;
use Modules\Availability\Entities\TeamAvailability;
use Modules\Bookings\Entities\Booking;
use Modules\Teams\Entities\Team;
use Modules\Tenants\Entities\Tenant;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Create a tenant1
        $tenant1 = Tenant::create([
            'name' => 'Tenant 1',
        ]);
        $tenant2 = Tenant::create([
            'name' => 'Tenant 2',
        ]);
        // Create a user
       $user1 = User::create([
            'name' => 'User One - Tenant 1',
            'email' => 'user1@tenant1.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant1->id,
        ]);

        $user2 = User::create([
            'name' => 'User Two - Tenant 1',
            'email' => 'user2@tenant1.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant1->id,
        ]);

        $user3 = User::create([
            'name' => 'User Three - Tenant 2',
            'email' => 'user3@tenant2.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant2->id,
        ]);

        $user4 = User::create([
            'name' => 'User Four - Tenant 2',
            'email' => 'user4@tenant2.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant2->id,
        ]);

        // Create a team
        $team1 = Team::create([
            'name' => 'Team Tenant 1',
            'description' => 'Description for Team Tenant 1',
            'created_by' => $user1->id,
            'tenant_id' => $tenant1->id,
        ]);

        $team2 = Team::create([
            'name' => 'Team Tenant 2',
            'description' => 'Description for Team Tenant 2',
            'created_by' => $user3->id,
            'tenant_id' => $tenant2->id,
        ]);

        // Team Availability (Monday 9-17, Wednesday 10-14)
        TeamAvailability::insert([
            [
                'team_id' => $team1->id,
                'day_of_week' => 'Monday',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => $team2->id,
                'day_of_week' => 'Wednesday',
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Create Bookings
        Booking::insert([
            [
                'team_id' => $team1->id,
                'user_id' => $user1->id,
                'date' => '2025-06-16',
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => $team2->id,
                'user_id' => $user3->id,
                'date' => '2025-06-18',
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    
    }
}
