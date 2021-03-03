<?php

namespace Database\Seeders;

use Faker\Provider\DateTime;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        $users = User::readers()->get();
        $types = ['lines', 'time'];

        $data = [];
        foreach ($users as $user) {
            for ($i=0; $i<50; $i++) {
                $date = DateTime::dateTimeBetween('-30 days', 'now');
                $data[] = [
                    'user_id' => $user->id,
                    'amount' => rand(5, 30),
                    'type' => $types[rand(0,1)],
                    'created_at' => $date->format('Y-m-d h:i:s'),
                    'updated_at' => $date->format('Y-m-d h:i:s')
                ];
            }
        }

        Transaction::insert($data);
    }
}
