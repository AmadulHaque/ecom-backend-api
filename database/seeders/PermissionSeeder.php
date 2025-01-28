<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Permission::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Create permissions
        $permissions = [
            ['guard_name' => 'admin', 'group_name' => 'dashboard', 'name' => 'cards'], // dashboard
            ['guard_name' => 'admin', 'group_name' => 'dashboard', 'name' => 'chart'], //

            ['guard_name' => 'admin', 'group_name' => 'order-payment', 'name' => 'order-payment-list'], // order-payment
            ['guard_name' => 'admin', 'group_name' => 'order-payment', 'name' => 'order-payment-show'], // //
            ['guard_name' => 'admin', 'group_name' => 'order-payment', 'name' => 'order-payment-update'], // //

            ['guard_name' => 'admin', 'group_name' => 'order', 'name' => 'order-list'], // order
            ['guard_name' => 'admin', 'group_name' => 'order', 'name' => 'order-show'], // //

            ['guard_name' => 'admin', 'group_name' => 'shop-product', 'name' => 'shop-product-list'], // shop-product
            ['guard_name' => 'admin', 'group_name' => 'shop-product', 'name' => 'shop-product-show'], // //

            ['guard_name' => 'admin', 'group_name' => 'product-request', 'name' => 'product-request-list'], // product-request
            ['guard_name' => 'admin', 'group_name' => 'product-request', 'name' => 'product-request-update'], // //
            ['guard_name' => 'admin', 'group_name' => 'product-request', 'name' => 'product-request-show'], // //

            ['guard_name' => 'admin', 'group_name' => 'merchant', 'name' => 'merchant-list'], // merchant
            ['guard_name' => 'admin', 'group_name' => 'merchant', 'name' => 'merchant-show'], // //
            ['guard_name' => 'admin', 'group_name' => 'merchant', 'name' => 'merchant-active'], // //
            ['guard_name' => 'admin', 'group_name' => 'merchant', 'name' => 'merchant-inactive'],

            ['guard_name' => 'admin', 'group_name' => 'prime-view', 'name' => 'prime-view-list'], // prime-view
            ['guard_name' => 'admin', 'group_name' => 'prime-view', 'name' => 'prime-view-create'], // //
            ['guard_name' => 'admin', 'group_name' => 'prime-view', 'name' => 'prime-view-update'], // //
            ['guard_name' => 'admin', 'group_name' => 'prime-view', 'name' => 'prime-view-delete'], // //

            ['guard_name' => 'admin', 'group_name' => 'prime-view-product', 'name' => 'prime-view-product-list'], // prime-view-product
            ['guard_name' => 'admin', 'group_name' => 'prime-view-product', 'name' => 'prime-view-product-create'], // //
            ['guard_name' => 'admin', 'group_name' => 'prime-view-product', 'name' => 'prime-view-product-delete'], // //

            ['guard_name' => 'admin', 'group_name' => 'location', 'name' => 'location-list'], // location
            ['guard_name' => 'admin', 'group_name' => 'location', 'name' => 'location-create'], // //
            ['guard_name' => 'admin', 'group_name' => 'location', 'name' => 'location-update'], // //

            ['guard_name' => 'admin', 'group_name' => 'reason', 'name' => 'reason-list'], // reason
            ['guard_name' => 'admin', 'group_name' => 'reason', 'name' => 'reason-create'], // //
            ['guard_name' => 'admin', 'group_name' => 'reason', 'name' => 'reason-update'], // //
            ['guard_name' => 'admin', 'group_name' => 'reason', 'name' => 'reason-delete'], // //

            ['guard_name' => 'admin', 'group_name' => 'customer', 'name' => 'customer-list'], // customer
            ['guard_name' => 'admin', 'group_name' => 'customer', 'name' => 'customer-show'], // //

            ['guard_name' => 'admin', 'group_name' => 'slider', 'name' => 'slider-create'], // slider
            ['guard_name' => 'admin', 'group_name' => 'slider', 'name' => 'slider-update'], // //
            ['guard_name' => 'admin', 'group_name' => 'slider', 'name' => 'slider-delete'], // //
            ['guard_name' => 'admin', 'group_name' => 'slider', 'name' => 'slider-list'], // //
        ];

        $newPermissions = [];

        foreach ($permissions as $permission) {
            // Check if the name already exists
            $exists = DB::table('permissions')->where('name', $permission['name'])->exists();

            if (! $exists) {
                $newPermissions[] = $permission;
                $this->command->info('Inserted: '.$permission['name']);
            } else {
                $this->command->info('The key already exists: '.$permission['name']);
            }
        }

        DB::table('permissions')->insert($newPermissions);
    }
}
