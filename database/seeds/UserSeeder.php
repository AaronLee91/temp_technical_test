<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test User 1',
            'email' => 'test1@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'default.jpg',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User 2',
            'email' => 'test2@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'default.jpg',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('users')->insert([
            'name' => 'Test Admin 1',
            'email' => 'test3@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'default.jpg',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User no Role',
            'email' => 'test4@gmail.com',
            'password' => Hash::make('password'),
            'profile_picture' => 'default.jpg',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
