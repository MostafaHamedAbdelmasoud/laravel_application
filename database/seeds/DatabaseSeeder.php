<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            VariantsTableSeeder::class,
            CitiesTableSeeder::class,
            MainProductsTypesTableSeeder::class,
            SubProductsTypesTableSeeder::class,
            MainProductsServiceTypesTableSeeder::class,
            SubProductsServiceTypesTableSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
        ]);
    }
}
