<?php

namespace Database\Seeders;

use App\Enum\UserRoleEnum;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => UserRoleEnum::ADMIN->value, 'guard_name' => config('auth.defaults.guard')]);
        $sellerRole = Role::create(['name' => UserRoleEnum::SELLER->value, 'guard_name' => config('auth.defaults.guard')]);

        $admin = User::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Admin',
            'email' => 'admin@hazde.com',
            'password' => Hash::make('AdMInHaZDe1234$'),
            'email_verified_at' => now()
        ]);
        $admin->assignRole($adminRole);
    }
}