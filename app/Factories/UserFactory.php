<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory
{
    /**
     * Create a user with validation (used by Admin UserController)
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

        // Create user with validated data
        $userData = array_merge($data, [
            'role' => $role,
            'password' => Hash::make($data['password']),
            'auth_method' => 'laravel', // Admin users use Laravel auth
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return User::create($userData);
    }
} 