<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = Category::all();

        for ($i = 1; $i <= 200; $i++) {
            Product::create([
                'category_id' => $categories->random()->id,
                'name' => "Продукт №$i",
                'description' => Str::random(100),
                'price' => rand(1000, 50000),
                'image' => "https://placehold.co/600x400?text=Product+$i"
            ]);
        }
    }
}
