<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = ['Umumi','Roman', 'Illuziya', 'Film', 'Resm', 'Senet', 'Insanliq', 'Dunya'];
        foreach ($categories as $value) {
            DB::table('categories')->insert([
                'name' => $value,
                'slug' => Str::slug($value, '-'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
