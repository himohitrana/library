<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $books = [
            // Fiction
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'category_id' => $categories->where('name', 'Fiction')->first()->id,
                'description' => 'A gripping tale of racial injustice and childhood innocence in the American South.',
                'price_sale' => 15.99,
                'price_rent' => 2.99,
                'stock' => 10,
                'status' => 'available',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'category_id' => $categories->where('name', 'Fiction')->first()->id,
                'description' => 'A dystopian social science fiction novel about totalitarian control.',
                'price_sale' => 14.99,
                'price_rent' => 2.99,
                'stock' => 8,
                'status' => 'available',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'category_id' => $categories->where('name', 'Fiction')->first()->id,
                'description' => 'A romantic novel about manners, upbringing, morality, and marriage.',
                'price_sale' => 12.99,
                'price_rent' => 2.49,
                'stock' => 12,
                'status' => 'available',
            ],

            // Science & Technology
            [
                'title' => 'The Innovators',
                'author' => 'Walter Isaacson',
                'category_id' => $categories->where('name', 'Science & Technology')->first()->id,
                'description' => 'How a group of hackers, geniuses, and geeks created the digital revolution.',
                'price_sale' => 18.99,
                'price_rent' => 3.99,
                'stock' => 6,
                'status' => 'available',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category_id' => $categories->where('name', 'Science & Technology')->first()->id,
                'description' => 'A handbook of agile software craftsmanship.',
                'price_sale' => 24.99,
                'price_rent' => 4.99,
                'stock' => 5,
                'status' => 'available',
            ],

            // Business & Economics
            [
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'category_id' => $categories->where('name', 'Business & Economics')->first()->id,
                'description' => 'The classic guide to wealth and success.',
                'price_sale' => 16.99,
                'price_rent' => 3.49,
                'stock' => 15,
                'status' => 'available',
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'category_id' => $categories->where('name', 'Business & Economics')->first()->id,
                'description' => 'How todays entrepreneurs use continuous innovation to create radically successful businesses.',
                'price_sale' => 19.99,
                'price_rent' => 3.99,
                'stock' => 7,
                'status' => 'available',
            ],

            // Self-Help
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'category_id' => $categories->where('name', 'Self-Help')->first()->id,
                'description' => 'Powerful lessons in personal change.',
                'price_sale' => 17.99,
                'price_rent' => 3.49,
                'stock' => 20,
                'status' => 'available',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'category_id' => $categories->where('name', 'Self-Help')->first()->id,
                'description' => 'An easy and proven way to build good habits and break bad ones.',
                'price_sale' => 18.99,
                'price_rent' => 3.99,
                'stock' => 25,
                'status' => 'available',
            ],

            // Mystery & Thriller
            [
                'title' => 'Gone Girl',
                'author' => 'Gillian Flynn',
                'category_id' => $categories->where('name', 'Mystery & Thriller')->first()->id,
                'description' => 'A psychological thriller about a marriage gone terribly wrong.',
                'price_sale' => 15.99,
                'price_rent' => 3.49,
                'stock' => 9,
                'status' => 'available',
            ],
            [
                'title' => 'The Girl with the Dragon Tattoo',
                'author' => 'Stieg Larsson',
                'category_id' => $categories->where('name', 'Mystery & Thriller')->first()->id,
                'description' => 'A gripping thriller about murder, family secrets, and financial corruption.',
                'price_sale' => 16.99,
                'price_rent' => 3.49,
                'stock' => 8,
                'status' => 'available',
            ],

            // Fantasy & Sci-Fi
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'category_id' => $categories->where('name', 'Fantasy & Sci-Fi')->first()->id,
                'description' => 'A fantasy adventure about a hobbit\'s unexpected journey.',
                'price_sale' => 14.99,
                'price_rent' => 2.99,
                'stock' => 18,
                'status' => 'available',
            ],
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'category_id' => $categories->where('name', 'Fantasy & Sci-Fi')->first()->id,
                'description' => 'A science fiction epic set in the distant future.',
                'price_sale' => 17.99,
                'price_rent' => 3.99,
                'stock' => 12,
                'status' => 'available',
            ],

            // Romance
            [
                'title' => 'The Notebook',
                'author' => 'Nicholas Sparks',
                'category_id' => $categories->where('name', 'Romance')->first()->id,
                'description' => 'A timeless love story that will break your heart and put it back together.',
                'price_sale' => 13.99,
                'price_rent' => 2.99,
                'stock' => 14,
                'status' => 'available',
            ],
            [
                'title' => 'Me Before You',
                'author' => 'Jojo Moyes',
                'category_id' => $categories->where('name', 'Romance')->first()->id,
                'description' => 'A heartbreaking romance about love, loss, and living life to the fullest.',
                'price_sale' => 15.99,
                'price_rent' => 3.49,
                'stock' => 11,
                'status' => 'available',
            ],

            // History
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'category_id' => $categories->where('name', 'History')->first()->id,
                'description' => 'A brief history of humankind.',
                'price_sale' => 19.99,
                'price_rent' => 4.49,
                'stock' => 16,
                'status' => 'available',
            ],
            [
                'title' => 'The Guns of August',
                'author' => 'Barbara W. Tuchman',
                'category_id' => $categories->where('name', 'History')->first()->id,
                'description' => 'A detailed account of the first month of World War I.',
                'price_sale' => 17.99,
                'price_rent' => 3.99,
                'stock' => 7,
                'status' => 'available',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
