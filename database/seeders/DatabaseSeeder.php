<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::firstOrCreate(
            ['email' => 'anderson@gmail.com'],
            [
                'name' => 'Anderson',
                'password' => Hash::make('admin123'),
                'is_verify' => true,
            ]
        );

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        if (!$admin->hasRole('super_admin')) {
            $admin->assignRole($superAdminRole);
            $this->command->info('✅ Assigned Super Admin role.');
        }

        Artisan::call('shield:generate', ['--all' => true]);
        $this->command->info('✅ Permissions generated successfully.');
    }
}
