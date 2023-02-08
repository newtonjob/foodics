<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'  => 'Burger '.uniqid(),
            'price' => fake()->numberBetween(50, 100)
        ])->ingredients()->attach([
            1 => ['quantity' => 150],
            2 => ['quantity' => 30],
            3 => ['quantity' => 20],
        ]);
    }
}
