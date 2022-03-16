<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SubscriptionTableSeeder::class);
        $this->call(ProcessesTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
