<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            // Category permissions
            'create-categories',
            'read-categories',
            'update-categories',
            'delete-categories',
            
            // Book permissions
            'create-books',
            'read-books',
            'update-books',
            'delete-books',
            
            // Enquiry permissions
            'read-all-enquiries',
            'update-enquiries',
            'delete-enquiries',
            
            // Rental permissions
            'create-rentals',
            'read-all-rentals',
            'update-rentals',
            
            // Sale permissions
            'create-sales',
            'read-all-sales',
            'update-sales',
            
            // Dashboard permissions
            'view-dashboard',
            'view-statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign basic permissions to user
        $userRole->givePermissionTo([
            'read-categories',
            'read-books',
        ]);
    }
}
