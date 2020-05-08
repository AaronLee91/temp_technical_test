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
        $this->call([
            UserSeeder::class,
            RolesSeeder::class,
            RolesUserSeeder::class,
            ArticlesSeeder::class,
            CommentsSeeder::class
        ]);
    }
}
