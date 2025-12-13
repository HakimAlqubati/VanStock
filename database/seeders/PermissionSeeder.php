<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions grouped by module
        $permissions = [
            // User Management
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Role & Permission Management
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',

            // Product Management
            'products.view',
            'products.create',
            'products.update',
            'products.delete',

            // Category Management
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            // Brand Management
            'brands.view',
            'brands.create',
            'brands.update',
            'brands.delete',

            // Customer Management
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',

            // Vendor Management
            'vendors.view',
            'vendors.create',
            'vendors.update',
            'vendors.delete',

            // Sales Invoice Management
            'sales_invoices.view',
            'sales_invoices.create',
            'sales_invoices.update',
            'sales_invoices.delete',

            // Sales Return Management
            'sales_returns.view',
            'sales_returns.create',
            'sales_returns.update',
            'sales_returns.delete',

            // Purchase Invoice Management
            'purchase_invoices.view',
            'purchase_invoices.create',
            'purchase_invoices.update',
            'purchase_invoices.delete',

            // Inventory Management
            'inventory.view',
            'inventory.create',
            'inventory.update',
            'inventory.delete',

            // Store Management
            'stores.view',
            'stores.create',
            'stores.update',
            'stores.delete',

            // Branch Management
            'branches.view',
            'branches.create',
            'branches.update',
            'branches.delete',

            // Payment Management
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',

            // Report Management
            'reports.view',
            'reports.export',

            // Settings Management
            'settings.view',
            'settings.update',

            // Attendance Management
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            // Employee Management
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.delete',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        $this->command->info('Permissions created successfully!');

        // Assign all permissions to super_admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo(Permission::all());
            $this->command->info('All permissions assigned to Super Admin role!');
        }

        // Assign specific permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminPermissions = Permission::whereIn('name', [
                'users.view',
                'users.create',
                'users.update',
                'products.view',
                'products.create',
                'products.update',
                'products.delete',
                'categories.view',
                'categories.create',
                'categories.update',
                'categories.delete',
                'brands.view',
                'brands.create',
                'brands.update',
                'brands.delete',
                'customers.view',
                'customers.create',
                'customers.update',
                'customers.delete',
                'vendors.view',
                'vendors.create',
                'vendors.update',
                'vendors.delete',
                'sales_invoices.view',
                'sales_invoices.create',
                'sales_invoices.update',
                'sales_returns.view',
                'sales_returns.create',
                'sales_returns.update',
                'purchase_invoices.view',
                'purchase_invoices.create',
                'purchase_invoices.update',
                'inventory.view',
                'inventory.create',
                'inventory.update',
                'stores.view',
                'stores.create',
                'stores.update',
                'branches.view',
                'branches.create',
                'branches.update',
                'payments.view',
                'payments.create',
                'payments.update',
                'reports.view',
                'reports.export',
                'attendance.view',
                'attendance.create',
                'attendance.update',
                'employees.view',
                'employees.create',
                'employees.update',
            ])->get();
            $adminRole->givePermissionTo($adminPermissions);
            $this->command->info('Permissions assigned to Admin role!');
        }

        // Assign specific permissions to manager role
        $managerRole = Role::where('name', 'manager')->first();
        if ($managerRole) {
            $managerPermissions = Permission::whereIn('name', [
                'products.view',
                'products.create',
                'products.update',
                'customers.view',
                'customers.create',
                'customers.update',
                'sales_invoices.view',
                'sales_invoices.create',
                'sales_invoices.update',
                'sales_returns.view',
                'sales_returns.create',
                'inventory.view',
                'reports.view',
                'reports.export',
                'attendance.view',
                'attendance.create',
                'employees.view',
            ])->get();
            $managerRole->givePermissionTo($managerPermissions);
            $this->command->info('Permissions assigned to Manager role!');
        }

        // Assign specific permissions to employee role
        $employeeRole = Role::where('name', 'employee')->first();
        if ($employeeRole) {
            $employeePermissions = Permission::whereIn('name', [
                'products.view',
                'customers.view',
                'sales_invoices.view',
                'inventory.view',
                'attendance.view',
                'attendance.create',
            ])->get();
            $employeeRole->givePermissionTo($employeePermissions);
            $this->command->info('Permissions assigned to Employee role!');
        }

        // Assign specific permissions to sales_representative role
        $salesRepRole = Role::where('name', 'sales_representative')->first();
        if ($salesRepRole) {
            $salesRepPermissions = Permission::whereIn('name', [
                'products.view',
                'customers.view',
                'customers.create',
                'customers.update',
                'sales_invoices.view',
                'sales_invoices.create',
                'sales_returns.view',
                'sales_returns.create',
                'payments.view',
                'payments.create',
                'attendance.view',
                'attendance.create',
            ])->get();
            $salesRepRole->givePermissionTo($salesRepPermissions);
            $this->command->info('Permissions assigned to Sales Representative role!');
        }
    }
}
