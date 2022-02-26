<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::create([
            'name' => 'Nasi Goreng',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi volutpat diam nec diam rutrum, ut commodo nunc viverra. Aliquam dignissim ac ex sit amet finibus. Donec vel felis ut tortor porttitor fermentum vel sodales est. Morbi sodales eget nunc vitae volutpat. Quisque maximus bibendum tellus et mollis. Nunc non suscipit urna, vitae facilisis ipsum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam dictum, mi eget faucibus tristique, nulla quam varius purus, nec eleifend elit sapien eget tortor. Donec vestibulum ut erat et varius. Nullam faucibus laoreet nisl, eu blandit urna tristique non. Aliquam sollicitudin viverra dui, ut tincidunt nibh sollicitudin sit amet. Nunc facilisis libero quis magna posuere, vel bibendum risus tincidunt. Nunc non lectus quam. Sed blandit ac felis sed accumsan.',
            'ingredients' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi volutpat diam nec diam rutrum, ut commodo nunc viverra. Aliquam dignissim ac ex sit amet finibus.',
            'category' => 'main course',
            'price' => '120000',
            'image' => 'images/menu/5KL3RdT6BlOCvUGqV8tURU30s8vPmQAZFZf6lGC4.jpg',
            'is_hidden' => 0
        ]);
    }
}
