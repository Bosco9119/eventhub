<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory
{
    /**
     * Create a new user based on role
     */
    public static function createUser(array $data, string $role = 'customer'): User
    {
        $userData = array_merge($data, [
            'role' => $role,
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);

        return User::create($userData);
    }

    /**
     * Create an admin user
     */
    public static function createAdmin(array $data): User
    {
        return self::createUser($data, 'admin');
    }

    /**
     * Create a vendor user
     */
    public static function createVendor(array $data): User
    {
        return self::createUser($data, 'vendor');
    }

    /**
     * Create a customer user
     */
    public static function createCustomer(array $data): User
    {
        return self::createUser($data, 'customer');
    }

    /**
     * Create a user with validation
     */
    public static function createUserWithValidation(array $data, string $role = 'customer'): User
    {
        // Validate required fields
        $requiredFields = ['name', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("Field '{$field}' is required");
            }
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format");
        }

        // Validate role
        $validRoles = ['admin', 'vendor', 'customer'];
        if (!in_array($role, $validRoles)) {
            throw new \InvalidArgumentException("Invalid role. Must be one of: " . implode(', ', $validRoles));
        }

        // Check if email already exists
        if (User::where('email', $data['email'])->exists()) {
            throw new \InvalidArgumentException("Email already exists");
        }

        return self::createUser($data, $role);
    }
} 