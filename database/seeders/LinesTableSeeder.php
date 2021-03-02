<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class LinesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = [];
        for ($i = 1; $i <= 100; $i++) {
            $lines[] = ['line_number' => $i];
        }

        for ($i = 1; $i <= 50; $i++) {
            \App\Models\Line::factory(100)
                ->state(new Sequence(
                    ...$lines
                ))
                ->create([
                    'book' => 'Book' . $i
                ]);
        }
    }
}
