<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(adminsSeeder::class);
        $this->call(agentSeeder::class);
        $this->call(policyHolderSeeder::class);
    }
}
