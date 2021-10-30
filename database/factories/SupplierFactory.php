<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\User;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => $faker->unique()->phoneNumber,
            'mobile' => $faker->unique()->phoneNumber,
            'no_identity' => $faker->nik(),
            'company' => $faker->company,
            'fax' => $faker->unique()->randomDigit,
            'address_payment' => $faker->address(),
            'address_delivery' => $faker->address(),
            'npwp' => $faker->unique()->randomDigit,
            'bank_name' => $this->faker->word,
            'bank_branch' => $faker->word,
            'bank_account_number' => $faker->unique()->randomDigit,
            'bank_account_handle_person' => $faker->name(),
            'user_id'=> User::all()->random()->id
        ];
    }
}
