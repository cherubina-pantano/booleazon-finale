<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Stockpile;
use Faker\Generator as Faker;

class StockpilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //Create a record for every stock
        $stockpiles = Product::all();
        foreach($stockpiles as $stockpile) {
            //create a new instance
            $newStockpile = new Stockpile();
            //Fill the table
            $newStockpile->product_id = $stockpile->id;
            $newStockpile->stockpile = $faker->randomNumber(2);
            $newStockpile->available = $faker->randomElement(['available' , 'not available' , 'in arrive']);
            //Save to DB
            $newStockpile->save();
        }
    }
}
