<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'owner@lmc.com'],
            [
                'name' => 'Owner LMC',
                'password' => bcrypt('password'),
                'role' => 'owner',
            ]
        );
    }
}
