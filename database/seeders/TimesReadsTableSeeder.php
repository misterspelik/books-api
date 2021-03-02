<?php

namespace Database\Seeders;

use Faker\Provider\DateTime;
use App\Models\User;
use App\Models\TimesRead;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TimesReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimesRead::truncate();

        $users = User::readers()->get();
        $transactions = Transaction::time()->get();

        $data = [];
        foreach ($users as $user) {
            for ($i=0; $i<50; $i++) {
                $date = DateTime::dateTimeBetween('-30 days', 'now');
                $data[] = [
                    'user_id' => $user->id,
                    'amount' => rand(5, 30),
                    'transaction_id' => $transactions->random()->id,
                    'created_at' => $date->format('Y-m-d h:i:s'),
                    'updated_at' => $date->format('Y-m-d h:i:s')
                ];
            }
        }

        TimesRead::insert($data);
    }
}
