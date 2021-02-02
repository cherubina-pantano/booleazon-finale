<?php

use Illuminate\Database\Seeder;
use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            //Create a faker name for Slug
            $name = $faker->word();
            //Create a new instance
            $newProduct = new Product();
            //Fill the table with faker
            $newProduct->name = $name;
            $newProduct->description = $faker->paragraph();
            $newProduct->price = $faker->randomFloat(2 , 100 , 499);
            $newProduct->slug = Str::slug($name , '-');
            //Save to DB
            $newProduct->save();
        }
    }
}
