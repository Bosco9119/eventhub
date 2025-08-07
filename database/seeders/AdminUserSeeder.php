<?php

namespace Database\Seeders;

use App\Factories\UserFactory;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        UserFactory::createAdmin([
            'name' => 'System Administrator',
            'email' => 'admin@eventhub.com',
            'password' => 'admin123456',
            'phone' => '+60123456789',
            'address' => 'TARUMT Main Campus, Kuala Lumpur',
        ]);

        // Create sample users for testing
        UserFactory::createVendor([
            'name' => 'John Vendor',
            'email' => 'vendor@example.com',
            'password' => 'vendor123456',
            'phone' => '+60123456788',
            'address' => '123 Vendor Street, KL',
        ]);

        UserFactory::createCustomer([
            'name' => 'Jane Customer',
            'email' => 'customer@example.com',
            'password' => 'customer123456',
            'phone' => '+60123456787',
            'address' => '456 Customer Avenue, KL',
        ]);

        $this->command->info('Admin and sample users created successfully!');
        $this->command->info('Admin credentials: admin@eventhub.com / admin123456');
        $this->command->info('Vendor credentials: vendor@example.com / vendor123456');
        $this->command->info('Customer credentials: customer@example.com / customer123456');
    }
} 