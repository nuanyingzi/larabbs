<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function definition()
    {
        $sentence = $this->faker->text(rand(10, 30));

        return [
            // $this->faker->name,
            'title' => $sentence,
            'body' => $this->faker->text(500),
            'excerpt' => $sentence,
            'user_id' => $this->faker->numberBetween(1, 10),
            'category_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
