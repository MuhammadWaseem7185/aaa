<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
            DB::table('products')->insert([
            [
                'name' => 'Mobile Phone ',
                'description' => 'Description for Product 1',
                'image' => 'mobile.JPEG',
                'price' => 19.99,
                'stock' => 100,
            ],
            [
                'name' => 'Laptop',
                'description' => 'Description for Product 2',
                'image' => 'laptop.JPEG',
                'price' => 29.99,
                'stock' => 150,
            ],
            [
                'name' => 'Headphones',
                'description' => 'Description for Product 3',
                'image' => 'headphone.JPEG',
                'price' => 39.99,
                'stock' => 200,
            ],
            [
                'name' => 'Smartwatch',
                'description' => 'Description for Product 4',
                'image' => 'smartwatch.JPEG',
                'price' => 49.99,
                'stock' => 250,
            ],
            [
                'name' => 'Camera',
                'description' => 'Description for Product 5',
                'image' => 'camera.JPEG',
                'price' => 59.99,
                'stock' => 300,
            ],  
            [
                'name' => 'Tablet',
                'description' => 'Description for Product 6',
                'image' => 'tablet.JPEG',
                'price' => 69.99,
                'stock' => 350,
            ],
            [
                'name' => 'Speaker',
                'description' => 'Description for Product 7',
                'image' => 'speaker.JPEG',
                'price' => 79.99,
                'stock' => 400,
            ],
            [
                'name' => 'Monitor',
                'description' => 'Description for Product 8',
                'image' => 'monitor.JPEG',
                'price' => 89.99,
                'stock' => 450,
            ],
            [
                'name' => 'Keyboard',
                'description' => 'Description for Product 9',
                'image' => 'keyboard.JPEG',
                'price' => 99.99,
                'stock' => 500,
            ],
            [
                'name' => 'Mouse',
                'description' => 'Description for Product 10',
                'image' => 'mouse.JPEG',
                'price' => 109.99,
                'stock' => 550,
            ],
            [
                'name' => 'Printer',
                'description' => 'Description for Product 11',
                'image' => 'printer.JPEG',
                'price' => 119.99,
                'stock' => 600,
            ],
            [
                'name' => 'Router',
                'description' => 'Description for Product 12',
                'image' => 'router.JPEG',
                'price' => 129.99,
                'stock' => 650,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => 'Description for Product 13',
                'image' => 'externalharddrive.JPEG',
                'price' => 139.99,
                'stock' => 700,
            ],
            [
                'name' => 'Webcam',
                'description' => 'Description for Product 14',
                'image' => 'webcam.JPEG',
                'price' => 149.99,
                'stock' => 750,
            ],
            [
                'name' => 'Microphone',
                'description' => 'Description for Product 15',
                'image' => 'microphone.JPEG',
                'price' => 159.99,
                'stock' => 800,
            ],
            [
                'name' => 'Projector',
                'description' => 'Description for Product 16',
                'image' => 'projector.JPEG',
                'price' => 169.99,
                'stock' => 850,
            ],
            [
                'name' => 'Gaming Console',
                'description' => 'Description for Product 17',
                'image' => 'gamingconsole.JPEG',
                'price' => 179.99,
                'stock' => 900,
            ],
            [
                'name' => 'VR Headset',
                'description' => 'Description for Product 18',
                'image' => 'vrheadset.JPEG',
                'price' => 189.99,
                'stock' => 950,
            ],
            [
                'name' => 'Smart Home Hub',
                'description' => 'Description for Product 19',
                'image' => 'smarthomehub.JPEG',
                'price' => 199.99,
                'stock' => 1000,
            ],
            [
                'name' => 'Fitness Tracker',
                'description' => 'Description for Product 20',
                'image' => 'fitnesstracker.JPEG',
                'price' => 209.99,
                'stock' => 1050,
            ],
            [
                'name' => 'E-Reader',
                'description' => 'Description for Product 21',
                'image' => 'ereader.JPEG',
                'price' => 219.99,
                'stock' => 1100,
            ],
        ]); 
    }
}
