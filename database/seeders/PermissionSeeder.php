<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Enum\UserRoleEnum;
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
        // Define roles and check if they already exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => config('auth.defaults.guard')]);
        $sellerRole = Role::firstOrCreate(['name' => 'seller', 'guard_name' => config('auth.defaults.guard')]);


        // Create permissions
        $blockUsers = Permission::firstOrCreate(['name' => PermissionEnum::BLOCK_USERS->value, 'guard_name' => config('auth.defaults.guard')]);
        $viewLoginLogs = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_USERS_LOGIN_LOGS->value, 'guard_name' => config('auth.defaults.guard')]);
        $viewAdminDashboardInfo = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_ADMIN_DASHBOARD->value, 'guard_name' => config('auth.defaults.guard')]);
        $viewContactUs = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_CONTACT_US->value, 'guard_name' => config('auth.defaults.guard')]);

        $viewCategories = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_CATEGORIES->value, 'guard_name' => config('auth.defaults.guard')]);
        $createCategory = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_CATEGORY->value, 'guard_name' => config('auth.defaults.guard')]);
        $editCategory = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_CATEGORY->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteCategory = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_CATEGORY->value, 'guard_name' => config('auth.defaults.guard')]);
        
        // Filter permissions
        $viewFilters = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_FILTERS->value, 'guard_name' => config('auth.defaults.guard')]);
        $createFilter = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_FILTER->value, 'guard_name' => config('auth.defaults.guard')]);
        $editFilter = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_FILTER->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteFilter = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_FILTER->value, 'guard_name' => config('auth.defaults.guard')]);
        
        // Filter option permissions
        $viewFilterOptions = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_FILTER_OPTIONS->value, 'guard_name' => config('auth.defaults.guard')]);
        $createFilterOption = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_FILTER_OPTION->value, 'guard_name' => config('auth.defaults.guard')]);
        $editFilterOption = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_FILTER_OPTION->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteFilterOption = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_FILTER_OPTION->value, 'guard_name' => config('auth.defaults.guard')]);

        $viewUsers = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_USERS->value, 'guard_name' => config('auth.defaults.guard')]);
        $createUser = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_USER->value, 'guard_name' => config('auth.defaults.guard')]);
        $editUser = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_USER->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteUser = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_USER->value, 'guard_name' => config('auth.defaults.guard')]);

        $viewAdmins = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_ADMINS->value, 'guard_name' => config('auth.defaults.guard')]);
        $createAdmin = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_ADMIN->value, 'guard_name' => config('auth.defaults.guard')]);
        $editAdmin = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_ADMIN->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteAdmin = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_ADMIN->value, 'guard_name' => config('auth.defaults.guard')]);


        // Seller permissions
        $viewSellerDashboard = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_SELLER_DASHBOARD->value, 'guard_name' => config('auth.defaults.guard')]);
        $createProduct = Permission::firstOrCreate(['name' => PermissionEnum::CREATE_PRODUCT->value, 'guard_name' => config('auth.defaults.guard')]);
        $editProduct = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_PRODUCT->value, 'guard_name' => config('auth.defaults.guard')]);
        $deleteProduct = Permission::firstOrCreate(['name' => PermissionEnum::DELETE_PRODUCT->value, 'guard_name' => config('auth.defaults.guard')]);
        $viewOrdersAsSeller = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_ORDERS_AS_SELLER->value, 'guard_name' => config('auth.defaults.guard')]);
        $editOrderStatusAsSeller = Permission::firstOrCreate(['name' => PermissionEnum::EDIT_ORDER_STATUS_AS_SELLER->value, 'guard_name' => config('auth.defaults.guard')]);
        
        // Product management permissions
        $viewProducts = Permission::firstOrCreate(['name' => PermissionEnum::VIEW_PRODUCTS->value, 'guard_name' => config('auth.defaults.guard')]);
        $approveProduct = Permission::firstOrCreate(['name' => PermissionEnum::APPROVE_PRODUCT->value, 'guard_name' => config('auth.defaults.guard')]);
        $rejectProduct = Permission::firstOrCreate(['name' => PermissionEnum::REJECT_PRODUCT->value, 'guard_name' => config('auth.defaults.guard')]);


        // Assign permissions to roles
        $adminRole->syncPermissions([
            // User management
            $blockUsers,
            $viewLoginLogs,
            $viewAdminDashboardInfo,
            $viewContactUs,
            $viewUsers,
            $createUser,
            $editUser,
            $deleteUser,
            $viewAdmins,
            $createAdmin,
            $editAdmin,
            $deleteAdmin,
            
            // Category and filter management
            $viewCategories,
            $createCategory,
            $editCategory,
            $deleteCategory,
            $viewFilters,
            $createFilter,
            $editFilter,
            $deleteFilter,
            $viewFilterOptions,
            $createFilterOption,
            $editFilterOption,
            $deleteFilterOption,
            
            // Product management
            $viewProducts,
            $approveProduct,
            $rejectProduct,
            $viewSellerDashboard,
            $createProduct,
            $editProduct,
            $deleteProduct,
            
            // Order management
            $viewOrdersAsSeller,
            $editOrderStatusAsSeller
        ]);
        
        // Assign seller permissions
        $sellerRole->syncPermissions([
            $viewSellerDashboard,
            $createProduct,
            $editProduct,
            $deleteProduct,
            $viewOrdersAsSeller,
            $editOrderStatusAsSeller
        ]);


    }
}