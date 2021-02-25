<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Employee::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition()
    {
        return [
                'name' => $this->faker->name(),
                'department_id' => '1',
                'phone' => '123123',
                'email' => $this->faker->unique()->safeEmail,
                'work_phone' => '0979540932',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '2021-02-20',

            //
        ];
    }
}
