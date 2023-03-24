<?php

namespace Database\Seeders;

use App\Enums\RoleAndPermissionsEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => RoleAndPermissionsEnum::Permission_User_Retrieve]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_User_Create]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_User_Edit]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_User_Delete]);

        Permission::create(['name' => RoleAndPermissionsEnum::Permission_Data_Retrieve]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_Data_Create]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_Data_Edit]);
        Permission::create(['name' => RoleAndPermissionsEnum::Permission_Data_Delete]);

        Role::create(['name' => RoleAndPermissionsEnum::Role_Admin])->givePermissionTo(Permission::all());
    }
}
