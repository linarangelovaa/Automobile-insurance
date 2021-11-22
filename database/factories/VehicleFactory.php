<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Fakecar;
use Faker\Generator as Faker;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $random_insurance_date = Carbon::today()->subDays(rand(0, 365))->format('Y-m-d');
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new Fakecar($faker));
        return [
            'brand' => $faker->vehicleBrand,
            'model' => $faker->vehicleModel,
            'plate_number' =>  $faker->vehicleRegistration('[A-Z]{2}-[0-9]{5}'),
            'date' =>   $random_insurance_date
        ];
    }
}