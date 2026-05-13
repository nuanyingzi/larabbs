<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $avatars = [
            'http://larabbs.test/uploads/images/avatars/卡通头像_小妹妹.png',
            'http://larabbs.test/uploads/images/avatars/狼头像.png',
            'http://larabbs.test/uploads/images/avatars/猫头像，卡通猫，卡通动物.png',
            'http://larabbs.test/uploads/images/avatars/猫头鹰博士头像，卡通动物.png',
            'http://larabbs.test/uploads/images/avatars/头像_狮子座.png',
            'http://larabbs.test/uploads/images/avatars/头像_天秤座.png',
            'http://larabbs.test/uploads/images/avatars/头像-兔3.png',
        ];
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'introduction' => $this->faker->sentence(),
            'avatar' => $avatars[$this->faker->numberBetween(0, 6)],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
