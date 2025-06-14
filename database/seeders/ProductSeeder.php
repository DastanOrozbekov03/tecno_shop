<?php

namespace Database\Seeders;

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
        // Создаем категории, если они отсутствуют, с уникальным slug
        $categories = [
            'Холодильники' => Category::firstOrCreate(
                ['name' => 'Холодильники'],
                ['slug' => Str::slug('Холодильники')]
            ),
            'Плиты' => Category::firstOrCreate(
                ['name' => 'Плиты'],
                ['slug' => Str::slug('Плиты')]
            ),
            'Стиральные машины' => Category::firstOrCreate(
                ['name' => 'Стиральные машины'],
                ['slug' => Str::slug('Стиральные машины')]
            ),
            'Телевизоры' => Category::firstOrCreate(
                ['name' => 'Телевизоры'],
                ['slug' => Str::slug('Телевизоры')]
            ),
        ];

        // Данные для товаров
        $products = [
            'Холодильники' => [
                [
                    'name' => 'Samsung RB33J3200WW',
                    'description' => 'Двухкамерный холодильник, объем 328 л, No Frost, энергопотребление A+, белый.',
                    'price' => 45000,
                    'image' => 'https://www.shutterstock.com/image-photo/modern-refrigerator-isolated-on-white-600x400',
                ],
                [
                    'name' => 'LG GA-B509CQSL',
                    'description' => 'Холодильник с инверторным компрессором, 384 л, Smart Diagnosis, серебристый.',
                    'price' => 52000,
                    'image' => 'https://www.shutterstock.com/image-photo/silver-refrigerator-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Bosch KGN39VW22R',
                    'description' => 'Холодильник с VitaFresh, 366 л, No Frost, энергопотребление A++, белый.',
                    'price' => 60000,
                    'image' => 'https://www.shutterstock.com/image-photo/white-refrigerator-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Haier C2F636CWRD',
                    'description' => 'Холодильник с Multi Air Flow, 364 л, No Frost, белый.',
                    'price' => 48000,
                    'image' => 'https://www.shutterstock.com/image-photo/modern-refrigerator-isolated-on-blue-600x400',
                ],
            ],
            'Плиты' => [
                [
                    'name' => 'Bosch HGG120E21S',
                    'description' => 'Газовая плита, 4 конфорки, духовка 60 л, автоподжиг, белая.',
                    'price' => 35000,
                    'image' => 'https://www.shutterstock.com/image-photo/gas-stove-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Electrolux EKK54553OX',
                    'description' => 'Комбинированная плита, 4 конфорки (2 газ + 2 электро), духовка 58 л, нержавеющая сталь.',
                    'price' => 42000,
                    'image' => 'https://www.shutterstock.com/image-photo/electric-stove-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Gorenje GI52CLI',
                    'description' => 'Газовая плита, 4 конфорки, духовка 50 л, чугунные решетки, бежевая.',
                    'price' => 38000,
                    'image' => 'https://www.shutterstock.com/image-photo/modern-gas-stove-isolated-on-600x400',
                ],
                [
                    'name' => 'Hansa FCMW58221',
                    'description' => 'Комбинированная плита, 4 конфорки, духовка 62 л, белая.',
                    'price' => 34000,
                    'image' => 'https://www.shutterstock.com/image-photo/kitchen-stove-isolated-on-white-600x400',
                ],
            ],
            'Стиральные машины' => [
                [
                    'name' => 'LG F2J3HS0W',
                    'description' => 'Стиральная машина, загрузка 7 кг, 1200 об/мин, инверторный двигатель, белая.',
                    'price' => 38000,
                    'image' => 'https://www.shutterstock.com/image-photo/washing-machine-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Samsung WW70A6S24AN',
                    'description' => 'Стиральная машина, 7 кг, 1400 об/мин, Eco Bubble, серебристая.',
                    'price' => 45000,
                    'image' => 'https://www.shutterstock.com/image-photo/modern-washing-machine-isolated-on-600x400',
                ],
                [
                    'name' => 'Bosch WAN2426XPL',
                    'description' => 'Стиральная машина, 8 кг, 1200 об/мин, EcoSilence Drive, белая.',
                    'price' => 50000,
                    'image' => 'https://www.shutterstock.com/image-photo/white-washing-machine-isolated-on-600x400',
                ],
                [
                    'name' => 'Electrolux EW6S4R27W',
                    'description' => 'Стиральная машина, 7 кг, 1200 об/мин, TimeCare, белая.',
                    'price' => 42000,
                    'image' => 'https://www.shutterstock.com/image-photo/washing-machine-isolated-on-blue-600x400',
                ],
            ],
            'Телевизоры' => [
                [
                    'name' => 'Samsung UE55AU8000',
                    'description' => '4K LED телевизор, 55 дюймов, Smart TV, черный.',
                    'price' => 65000,
                    'image' => 'https://www.shutterstock.com/image-photo/flat-screen-television-isolated-on-600x400',
                ],
                [
                    'name' => 'LG OLED55C1PVB',
                    'description' => 'OLED телевизор, 55 дюймов, 4K, webOS, черный.',
                    'price' => 95000,
                    'image' => 'https://www.shutterstock.com/image-photo/modern-tv-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Sony KD-55X85J',
                    'description' => '4K LED телевизор, 55 дюймов, Google TV, черный.',
                    'price' => 85000,
                    'image' => 'https://www.shutterstock.com/image-photo/led-television-isolated-on-white-600x400',
                ],
                [
                    'name' => 'Philips 55PUS7956/12',
                    'description' => '4K LED телевизор, 55 дюймов, Ambilight, Android TV, серебристый.',
                    'price' => 70000,
                    'image' => 'https://www.shutterstock.com/image-photo/smart-tv-isolated-on-white-600x400',
                ],
            ],
        ];

        // Заполняем остальные товары
        foreach ($products as $categoryName => $items) {
            $category = $categories[$categoryName];
            $count = count($items);
            $remaining = 25 - $count; // Нужно 25 товаров на категорию

            // Копируем существующие товары с вариациями
            for ($i = 0; $i < $remaining; $i++) {
                $baseItem = $items[$i % $count];
                Product::create([
                    'category_id' => $category->id,
                    'name' => $baseItem['name'] . ' ' . ($i + 1),
                    'description' => $baseItem['description'],
                    'price' => $baseItem['price'] + rand(-5000, 5000),
                    'image' => $baseItem['image'],
                ]);
            }

            // Добавляем базовые товары
            foreach ($items as $item) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                ]);
            }
        }
    }
}
