<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'title' => 'user_management_access',
            ],
            [
                'id' => 2,
                'title' => 'permission_create',
            ],
            [
                'id' => 3,
                'title' => 'permission_edit',
            ],
            [
                'id' => 4,
                'title' => 'permission_show',
            ],
            [
                'id' => 5,
                'title' => 'permission_delete',
            ],
            [
                'id' => 6,
                'title' => 'permission_access',
            ],
            [
                'id' => 7,
                'title' => 'role_create',
            ],
            [
                'id' => 8,
                'title' => 'role_edit',
            ],
            [
                'id' => 9,
                'title' => 'role_show',
            ],
            [
                'id' => 10,
                'title' => 'role_delete',
            ],
            [
                'id' => 11,
                'title' => 'role_access',
            ],
            [
                'id' => 12,
                'title' => 'user_create',
            ],
            [
                'id' => 13,
                'title' => 'user_edit',
            ],
            [
                'id' => 14,
                'title' => 'user_show',
            ],
            [
                'id' => 15,
                'title' => 'user_delete',
            ],
            [
                'id' => 16,
                'title' => 'user_access',
            ],
            [
                'id' => 17,
                'title' => 'advertisement_create',
            ],
            [
                'id' => 18,
                'title' => 'advertisement_edit',
            ],
            [
                'id' => 19,
                'title' => 'advertisement_show',
            ],
            [
                'id' => 20,
                'title' => 'advertisement_delete',
            ],
            [
                'id' => 21,
                'title' => 'advertisement_access',
            ],
            [
                'id' => 22,
                'title' => 'city_create',
            ],
            [
                'id' => 23,
                'title' => 'city_edit',
            ],
            [
                'id' => 24,
                'title' => 'city_show',
            ],
            [
                'id' => 25,
                'title' => 'city_delete',
            ],
            [
                'id' => 26,
                'title' => 'city_access',
            ],
            [
                'id' => 27,
                'title' => 'department_create',
            ],
            [
                'id' => 28,
                'title' => 'department_edit',
            ],
            [
                'id' => 29,
                'title' => 'department_show',
            ],
            [
                'id' => 30,
                'title' => 'department_delete',
            ],
            [
                'id' => 31,
                'title' => 'department_access',
            ],
            [
                'id' => 32,
                'title' => 'category_create',
            ],
            [
                'id' => 33,
                'title' => 'category_edit',
            ],
            [
                'id' => 34,
                'title' => 'category_show',
            ],
            [
                'id' => 35,
                'title' => 'category_delete',
            ],
            [
                'id' => 36,
                'title' => 'category_access',
            ],
            [
                'id' => 37,
                'title' => 'branch_access',
            ],
            [
                'id' => 38,
                'title' => 'offer_create',
            ],
            [
                'id' => 39,
                'title' => 'offer_edit',
            ],
            [
                'id' => 40,
                'title' => 'offer_show',
            ],
            [
                'id' => 41,
                'title' => 'offer_delete',
            ],
            [
                'id' => 42,
                'title' => 'offer_access',
            ],
            [
                'id' => 43,
                'title' => 'manage_application_access',
            ],
            [
                'id' => 44,
                'title' => 'specialization_create',
            ],
            [
                'id' => 45,
                'title' => 'specialization_edit',
            ],
            [
                'id' => 46,
                'title' => 'specialization_show',
            ],
            [
                'id' => 47,
                'title' => 'specialization_delete',
            ],
            [
                'id' => 48,
                'title' => 'specialization_access',
            ],
            [
                'id' => 49,
                'title' => 'job_create',
            ],
            [
                'id' => 50,
                'title' => 'job_edit',
            ],
            [
                'id' => 51,
                'title' => 'job_show',
            ],
            [
                'id' => 52,
                'title' => 'job_delete',
            ],
            [
                'id' => 53,
                'title' => 'job_access',
            ],
            [
                'id' => 54,
                'title' => 'news_create',
            ],
            [
                'id' => 55,
                'title' => 'news_edit',
            ],
            [
                'id' => 56,
                'title' => 'news_show',
            ],
            [
                'id' => 57,
                'title' => 'news_delete',
            ],
            [
                'id' => 58,
                'title' => 'news_access',
            ],
            [
                'id' => 59,
                'title' => 'notification_create',
            ],
            [
                'id' => 60,
                'title' => 'notification_edit',
            ],
            [
                'id' => 61,
                'title' => 'notification_show',
            ],
            [
                'id' => 62,
                'title' => 'notification_delete',
            ],
            [
                'id' => 63,
                'title' => 'notification_access',
            ],
            [
                'id' => 64,
                'title' => 'job_offer_create',
            ],
            [
                'id' => 65,
                'title' => 'job_offer_edit',
            ],
            [
                'id' => 66,
                'title' => 'job_offer_show',
            ],
            [
                'id' => 67,
                'title' => 'job_offer_delete',
            ],
            [
                'id' => 68,
                'title' => 'job_offer_access',
            ],
            [
                'id' => 69,
                'title' => 'trader_create',
            ],
            [
                'id' => 70,
                'title' => 'trader_edit',
            ],
            [
                'id' => 71,
                'title' => 'trader_show',
            ],
            [
                'id' => 72,
                'title' => 'trader_delete',
            ],
            [
                'id' => 73,
                'title' => 'trader_access',
            ],
            [
                'id' => 74,
                'title' => 'product_create',
            ],
            [
                'id' => 75,
                'title' => 'product_edit',
            ],
            [
                'id' => 76,
                'title' => 'product_show',
            ],
            [
                'id' => 77,
                'title' => 'product_delete',
            ],
            [
                'id' => 78,
                'title' => 'product_access',
            ],
            [
                'id' => 79,
                'title' => 'profile_password_edit',

            ],
            [
                'id' => 80,
                'title' => 'coupon_access',

            ],
            [
                'id' => 81,
                'title' => 'coupon_delete',

            ],
            [
                'id' => 82,
                'title' => 'coupon_show',

            ],
            [
                'id' => 83,
                'title' => 'coupon_edit',

            ],
            [
                'id' => 84,
                'title' => 'coupon_create',

            ],
            [
                'id' => 85,
                'title' => 'order_create',

            ],
            [
                'id' => 86,
                'title' => 'order_access',

            ],
            [
                'id' => 87,
                'title' => 'order_delete',

            ],
            [
                'id' => 88,
                'title' => 'order_show',

            ],
            [
                'id' => 89,
                'title' => 'order_edit',

            ],
        ];

        Permission::insert($permissions);
    }
}
