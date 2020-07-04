<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 4; $i++) {
            $title = $faker->jobTitle;
            DB::table('articles')->insert([
                'category_id' => rand(1, 7),
                'title' => $title,
                'image' => $faker->imageUrl(800, 400,'cats',true),
                'content' => $faker->paragraph(),
                'slug' => Str::slug($title), 
                'created_at' => $faker->dateTime('now'),
                'updated_at' => now(),
            ]);
        }
    }
}
