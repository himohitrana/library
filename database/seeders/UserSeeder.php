<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'address' => '123 Admin Street, Admin City, AC 12345',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'address' => '456 User Street, User City, UC 12345',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'address' => '789 Customer Avenue, Customer City, CC 12345',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567893',
                'address' => '321 Reader Road, Reader City, RC 12345',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole('user');
        }
    }
}
