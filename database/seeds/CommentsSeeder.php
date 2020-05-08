<?php

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = 'Article 1';
        DB::table('comments')->insert([
            'body' => ' Comment 1 for Article 1',
            'user_id' => 1,
            'article_id' => 1,
            'slug' => Str::slug(Str::slug($title, '-') . " " . time() . rand(10, 99)),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
        // wait for 0.05 seconds
        usleep(50000);

        $title = 'Article 1';
        DB::table('comments')->insert([
            'body' => ' Comment 2 for Article 1',
            'user_id' => 2,
            'article_id' => 1,
            'slug' => Str::slug(Str::slug($title, '-') . " " . time() . rand(10, 99)),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
        // wait for 0.05 seconds
        usleep(50000);

        $title = 'Article 2';
        DB::table('comments')->insert([
            'body' => ' Comment 1 for Article 2',
            'user_id' => 2,
            'article_id' => 2,
            'slug' => Str::slug(Str::slug($title, '-') . " " . time() . rand(10, 99)),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
        // wait for 0.05 seconds
        usleep(50000);

        $title = 'Article 2';
        DB::table('comments')->insert([
            'body' => ' Comment 2 for Article 2',
            'user_id' => 1,
            'article_id' => 2,
            'slug' => Str::slug(Str::slug($title, '-') . " " . time() . rand(10, 99)),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
        // wait for 0.05 seconds
        usleep(50000);

        $title = 'Article 2';
        DB::table('comments')->insert([
            'body' => ' Comment 3 for Article 2',
            'user_id' => 3,
            'article_id' => 2,
            'slug' => Str::slug(Str::slug($title, '-') . " " . time() . rand(10, 99)),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]);
    }
}
