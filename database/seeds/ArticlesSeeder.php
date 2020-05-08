<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = 'Article 1';
        DB::table('articles')->insert([
            'title' => $title,
            'description' => ' Content of Article 1',
            'user_id' => 1,
            'slug' => Str::slug($title, '-'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);

        $title = 'Article 2';
        DB::table('articles')->insert([
            'title' => $title,
            'description' => ' Content of Article 2',
            'user_id' => 2,
            'slug' => Str::slug($title, '-'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
    }
}
