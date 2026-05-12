<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\User; 
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'user_id' => User::factory(), // Cria um novo usuário automaticamente
        'book_id' => Book::inRandomOrder()->first()->id, // Seleciona um livro aleatório existente[cite: 1]
        'borrowed_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Data de empréstimo (mês passado até hoje)[cite: 1]
        'returned_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'), // Data de devolução opcional[cite: 1]
    ];
}
}
