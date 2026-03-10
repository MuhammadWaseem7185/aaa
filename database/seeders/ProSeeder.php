<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\product;

class ProSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
           [
                'name' => 'Smart TV',
                'description' => 'Description for Product 7',
                'image' => 'smarttv.JPEG',
                'price' => 79.99,
                'stock' => 400,
            ],
            [
                'name' => 'Speaker',
                'description' => 'Description for Product 8',
                'image' => 'speaker.JPEG',
                'price' => 89.99,
                'stock' => 450,
            ],
            [
                'name' => 'Monitor',
                'description' => 'Description for Product 9',
                'image' => 'monitor.JPEG',
                'price' => 99.99,
                'stock' => 500,
            ],
            [
                'name' => 'Keyboard',
                'description' => 'Description for Product 10',
                'image' => 'keyboard.JPEG',
                'price' => 109.99,
                'stock' => 550,
            ],
            [
                'name' => 'Mouse',
                'description' => 'Description for Product 11',
                'image' => 'mouse.JPEG',
                'price' => 119.99,
                'stock' => 600,
            ],
            [
                'name' => 'Printer',
                'description' => 'Description for Product 12',
                'image' => 'printer.JPEG',
                'price' => 129.99,
                'stock' => 650,
            ],
            [
                'name' => 'Router',
                'description' => 'Description for Product 13',
                'image' => 'router.JPEG',
                'price' => 139.99,
                'stock' => 700,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => 'Description for Product 14',
                'image' => 'externalharddrive.JPEG',
                'price' => 149.99,
                'stock' => 750,
            ],
            [
                'name' => 'Webcam',
                'description' => 'Description for Product 15',
                'image' => 'webcam.JPEG',
                'price' => 159.99,
                'stock' => 800,
            ],
            [
                'name' => 'Microphone',
                'description' => 'Description for Product 16',
                'image' => 'microphone.JPEG',
                'price' => 169.99,
                'stock' => 850,
            ],[
                'name' => 'Projector',
                'description' => 'Description for Product 17',
                'image' => 'projector.JPEG',
                'price' => 179.99,
                'stock' => 900,
            ],
            [
                'name' => 'Gaming Console',
                'description' => 'Description for Product 18',
                'image' => 'gamingconsole.JPEG',
                'price' => 189.99,
                'stock' => 950,
            ],
            [
                'name' => 'VR Headset',
                'description' => 'Description for Product 19',
                'image' => 'vrheadset.JPEG',
                'price' => 199.99,
                'stock' => 1000,
            ],
            [
                'name' => 'Smart Home Hub',
                'description' => 'Description for Product 20',
                'image' => 'smarthomehub.JPEG',
                'price' => 209.99,
                'stock' => 1050,
            ],
            [
                'name' => 'Fitness Tracker',
                'description' => 'Description for Product 21',
                'image' => 'fitnesstracker.JPEG',
                'price' => 219.99,
                    'stock' => 1100,
            ],
            [
                'name' => 'E-Reader',
                'description' => 'Description for Product 22',
                'image' => 'ereader.JPEG',
                'price' => 229.99,
                'stock' => 1150,
               
            ],
            [
                'name' => 'Drone',
                'description' => 'Description for Product 23',
                'image' => 'drone.JPEG',
                'price' => 239.99,
                'stock' => 1200
            ]
          

        ]);
    }
}
