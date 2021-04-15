<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'judul' => $this->faker->word(),
            'biaya' => $this->faker->numberBetween(0, 100000000),
            'time' => $this->faker->dateTime(now()),
            'jenis' =>  $this->faker->randomElement(['pengeluaran', 'pendapatan'])
        ];
    }
}
