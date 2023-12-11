<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Book::factory(35)->create()->each(function ($book) {
            $numReviews = random_int(5, 10);

            Review::factory($numReviews)
                ->good()
                ->for($book)
                ->create();
         });

         Book::factory(15)->create()->each(function ($book) {
            $numReviews = random_int(3, 7);

            Review::factory($numReviews)
                ->average()
                ->for($book)
                ->create();
         });

         Book::factory(20)->create()->each(function ($book) {
            $numReviews = random_int(7, 15);

            Review::factory($numReviews)
                ->bad()
                ->for($book)
                ->create();
         });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
