<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Secure admin password — change after first login if this file is shared.
     */
    public const ADMIN_PASSWORD = 'Ch@nceAdm#9Kx7mP2!';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove all non-admin users
        $deletedCustomers = User::where('role', '!=', 'admin')->delete();
        $this->command->info("Removed {$deletedCustomers} non-admin user(s).");

        // Keep a single admin account
        User::where('role', 'admin')
            ->where('email', '!=', 'admin@chancelaptops.com')
            ->delete();

        User::updateOrCreate(
            ['email' => 'admin@chancelaptops.com'],
            [
                'name' => 'Chance Laptops Admin',
                'password' => self::ADMIN_PASSWORD,
                'role' => 'admin',
                'status' => 'active',
                'phone' => '0112959005',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin ready: admin@chancelaptops.com');
        $this->command->warn('Password: ' . self::ADMIN_PASSWORD);
    }
}
