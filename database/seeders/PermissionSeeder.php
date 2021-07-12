<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'category_create',
            'category_update',
            'category_delete',

            'order_show',
            'order_access',
            'order_create',
            'order_update',
            'order_delete',

            'product_create',
            'product_update',
            'product_delete',

            'user_access',
            'user_show',
            'user_create',
            'user_update',
            'user_delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $buyerPermissions = [
            'order_show',
            'order_access'
        ];
        $buyer = Role::where("name", '=', 'buyer')->first();
        $buyer->syncPermissions($buyerPermissions);

        $merchantPermissions = [
            'product_create',
            'product_update',
            'product_delete',
            'order_show',
            'order_access'
        ];

        $merchantUser = Role::where('name', '=', 'merchant')->first();
        $merchantUser->syncPermissions($merchantPermissions);
    }
}
