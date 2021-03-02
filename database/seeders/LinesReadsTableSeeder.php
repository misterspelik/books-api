<?php

namespace Database\Seeders;

use Faker\Provider\DateTime;
use App\Models\User;
use App\Models\Line;
use App\Models\LinesRead;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class LinesReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LinesRead::truncate();

        $users = User::readers()->get();
        $transactions = Transaction::lines()->get();
        $lines = Line::get();

        $data = [];
        foreach ($users as $user) {
            for ($i=0; $i<50; $i++) {
                $date = DateTime::dateTimeBetween('-30 days', 'now');
                $data[] = [
                    'user_id' => $user->id,
                    'line_id' => $lines->random()->id,
                    'transaction_id' => $transactions->random()->id,
                    'created_at' => $date->format('Y-m-d h:i:s'),
                    'updated_at' => $date->format('Y-m-d h:i:s')
                ];
            }
        }

        LinesRead::insert($data);
    }
}
