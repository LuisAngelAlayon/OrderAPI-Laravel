<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert([
            [
                'legalization_date' => '2022-01-01',
                'address' => 'Calle 1',
                'city' => 'Springfield',
                'Observation_id' => null,
                'causal_id' => 1
            ],
            [
                'legalization_date' => '2022-01-01',
                'address' => 'Calle 2 falsa',
                'city' => 'Springfield',
                'Observation_id' => 1,
                'causal_id' => 2
            ]
        ]);
    }
}
