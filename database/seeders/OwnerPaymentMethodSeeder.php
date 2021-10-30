<?php

namespace Database\Seeders;

use App\Models\OwnerPaymentMethod;
use Illuminate\Database\Seeder;

class OwnerPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ownerPaymentMethod = new OwnerPaymentMethod();
        $ownerPaymentMethod->owner_id = 1;
        $ownerPaymentMethod->payment_method_id = 1;
        $ownerPaymentMethod->save();
    }
}
