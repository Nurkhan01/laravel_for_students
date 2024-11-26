<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CreateRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:create {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles, permissions, and assign roles to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating roles and permissions...');

        // Создание разрешений
        $dontStop = Permission::firstOrCreate(['name' => 'dont_stop']);
        $crudProduct = Permission::firstOrCreate(['name' => 'crud_product']);

        // Создание ролей
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);

        // Привязка разрешений к ролям
        $adminRole->givePermissionTo($dontStop);
        $moderatorRole->givePermissionTo($crudProduct);

        $this->info('Roles and permissions created successfully.');

        // Привязка роли к пользователю
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found.');
            return Command::FAILURE;
        }

        $this->info('Assigning admin role to the user...');
        $user->assignRole('admin'); // Здесь можно заменить на 'moderator' для другой роли

        $this->info("Role 'admin' assigned to user ID {$userId} successfully.");
        return Command::SUCCESS;
    }
}
