<?php

namespace Database\Seeders;

use \App\Models\Transaction;
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
        Transaction::factory(100)->lines()->create();
        Transaction::factory(100)->time()->create();
    }
}
