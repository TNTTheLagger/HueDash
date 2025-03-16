<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    public function run()
    {
        DB::table('topics')->insert([
            [
                'name'       => 'Topic1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Topic2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
