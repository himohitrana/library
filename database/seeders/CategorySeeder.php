<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Fictional stories, novels, and literature'
            ],
            [
                'name' => 'Non-Fiction',
                'description' => 'Educational, biographical, and factual books'
            ],
            [
                'name' => 'Science & Technology',
                'description' => 'Books about science, technology, and innovation'
            ],
            [
                'name' => 'History',
                'description' => 'Historical books, biographies, and documentaries'
            ],
            [
                'name' => 'Business & Economics',
                'description' => 'Business strategies, economics, and entrepreneurship'
            ],
            [
                'name' => 'Self-Help',
                'description' => 'Personal development and self-improvement books'
            ],
            [
                'name' => 'Romance',
                'description' => 'Romantic novels and love stories'
            ],
            [
                'name' => 'Mystery & Thriller',
                'description' => 'Mystery novels, thrillers, and suspense stories'
            ],
            [
                'name' => 'Fantasy & Sci-Fi',
                'description' => 'Fantasy novels and science fiction stories'
            ],
            [
                'name' => 'Children & Young Adult',
                'description' => 'Books for children and young adult readers'
            ],
            [
                'name' => 'Health & Fitness',
                'description' => 'Health, fitness, and wellness guides'
            ],
            [
                'name' => 'Travel',
                'description' => 'Travel guides and adventure stories'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
