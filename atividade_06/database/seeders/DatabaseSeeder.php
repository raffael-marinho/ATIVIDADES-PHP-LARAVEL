<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;      // <--- Adicionado
use App\Models\Borrowing; // <--- Adicionado
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        if (Book::count() === 0) {
            Book::factory(10)->create(); 
        }

        $this->call([
            UserBorrowingSeeder::class,
        ]);
    }
}