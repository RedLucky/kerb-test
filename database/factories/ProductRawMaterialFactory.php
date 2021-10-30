<?php

namespace Database\Factories;

use App\Models\ProductRawMaterial;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\User;

class ProductRawMaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductRawMaterial::class;

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
            'produsen'=>$faker->company,
            'condition'=>$faker->word,
            'available_document'=>$faker->word,
            'user_id' => User::all()->random()->id
        ];
    }
}
