<?php

namespace Database\Seeders;

use App\Models\Bay;
use Illuminate\Database\Seeder;

class BaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bay = new Bay();
        $bay->owner_id = 1;
        $bay->width = 1.8;
        $bay->length = 2.3;
        $bay->location_name = "Surabaya";
        $bay->name = "Parking lucky Free tea";
        $bay->coordinate = "-7.255351342217526, 112.7517859762975";
        $bay->save();

        $bay = new Bay();
        $bay->owner_id = 1;
        $bay->width = 1.8;
        $bay->length = 2.3;
        $bay->location_name = "Surabaya";
        $bay->name = "Parking lucky Free coffe";
        $bay->coordinate = "-7.255351342217526, 112.7517859762975";
        $bay->save();

        $bay = new Bay();
        $bay->owner_id = 1;
        $bay->width = 1.8;
        $bay->length = 2.3;
        $bay->location_name = "Surabaya";
        $bay->name = "Parking lucky Free mineral water";
        $bay->coordinate = "-7.255351342217526, 112.7517859762975";
        $bay->save();
    }
}
