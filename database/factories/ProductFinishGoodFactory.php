<?php

namespace Database\Factories;

use App\Models\ProductFinishGood;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;

class ProductFinishGoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductFinishGood::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        return [
            'name'=>$faker->word,
            'qty'=>$faker->randomDigit,
            'uom'=>$this->faker->randomElement(['Kg', 'Pcs','Meter','Gr','Ton']),
            'no_batch'=>$faker->word,
            'expired'=>$faker->date,
            'bruto'=>$faker->randomDigit,
            'netto'=>$faker->randomDigit,
            'price'=>$faker->randomDigit,
            'distributor_name'=>$faker->company,
            'user_id' => User::all()->random()->id
        ];
    }
}
