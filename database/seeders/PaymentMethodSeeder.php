<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = "bank transfer";
        $paymentMethod->save();
    }
}
