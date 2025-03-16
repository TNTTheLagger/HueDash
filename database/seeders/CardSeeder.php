<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    public function run()
    {
        $cards = [];
        for ($i = 1; $i <= 100; $i++) {
            $cards[] = [
                'title'      => "Card $i",
                'body'       => "This is card number $i.",
                'urgency'    => $i % 3 == 0 ? 'high' : ($i % 3 == 1 ? 'medium' : 'low'),
                'topic_id'   => $i % 2 == 0 ? 1 : 2,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cards')->insert($cards);
    }
}
