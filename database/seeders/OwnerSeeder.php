<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $owner = new Owner();
        $owner->name = "lucky Fernanda Owner";
        $owner->email = "lucky@gmail.com";
        $owner->total_bays = 3;
        $owner->save();
    }
}
