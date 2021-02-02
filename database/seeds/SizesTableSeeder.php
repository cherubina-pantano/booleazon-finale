<?php

use Illuminate\Database\Seeder;
use App\Size;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            'small',
            'medium',
            'large',
            'extra-large',
        ];

        foreach($sizes as $size) {
            //Create a new instance
            $newSize = new Size();
            //Fill the table
            $newSize->size = $size;
            //Save to DB
            $newSize->save();
        }
    }
}
