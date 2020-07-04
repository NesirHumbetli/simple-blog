<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Haqqımızda','Karyera','Hədəf','Misiya'];
        $count = 0;
        foreach($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title' => $page,
                'image' => 'https://pestleanalysis.com/wp-content/uploads/2016/03/business-plan.jpg',
                'slug' => Str::slug($page,'-'),
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tempora repellendus! Odio sit deserunt qui voluptates soluta, eos vero ipsam doloremque porro nihil quae! Saepe voluptas hic est quo laborum.',
                'order' => $count,
                'created_at' => now(),
                'created_at' => now(),
            ]);
        }
    }
}
