<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 548; $i < 649 ; $i++){
            for ($j = 1; $j <= 4; $j++){
                $data['post_id'] = $i;
                $data['tag_id'] = random_int(2,6);
                DB::table('post_tag')->insert($data);
            }
        }
    }
}
