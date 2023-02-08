<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingredient::insert([
            [
                'name'                => 'Beef',
                'stock'               => 20000,
                'low_stock_threshold' => 10000
            ],
            [
                'name'                => 'Cheese',
                'stock'               => 5000,
                'low_stock_threshold' => 2500
            ],
            [
                'name'                => 'Onion',
                'stock'               => 1000,
                'low_stock_threshold' => 500
            ]
        ]);
    }
}
