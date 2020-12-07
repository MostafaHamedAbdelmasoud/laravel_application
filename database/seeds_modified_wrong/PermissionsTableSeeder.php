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
            [
                'id' => 90,
                'title' => 'sub_category_create',

            ],
            [
                'id' => 91,
                'title' => 'sub_category_access',

            ],
            [
                'id' => 92,
                'title' => 'sub_category_delete',

            ],
            [
                'id' => 93,
                'title' => 'sub_category_show',

            ],
            [
                'id' => 94,
                'title' => 'sub_category_edit',

            ],
            [
                'id' => 95,
                'title' => 'news_category_create',

            ],
            [
                'id' => 96,
                'title' => 'news_category_access',

            ],
            [
                'id' => 97,
                'title' => 'news_category_delete',

            ],
            [
                'id' => 98,
                'title' => 'news_category_show',

            ],
            [
                'id' => 99,
                'title' => 'news_category_edit',

            ],
            [
                'id' => 100,
                'title' => 'news_sub_category_create',

            ],
            [
                'id' => 101,
                'title' => 'news_sub_category_access',

            ],
            [
                'id' => 102,
                'title' => 'news_sub_category_delete',

            ],
            [
                'id' => 103,
                'title' => 'news_sub_category_show',

            ],
            [
                'id' => 104,
                'title' => 'news_sub_category_edit',

            ],
            [
                'id' => 105,
                'title' => 'main_product_type_create',

            ],
            [
                'id' => 106,
                'title' => 'main_product_type_access',

            ],
            [
                'id' => 107,
                'title' => 'main_product_type_delete',

            ],
            [
                'id' => 108,
                'title' => 'main_product_type_show',

            ],
            [
                'id' => 109,
                'title' => 'main_product_type_edit',

            ],
            [
                'id' => 110,
                'title' => 'sub_product_type_create',

            ],
            [
                'id' => 111,
                'title' => 'sub_product_type_access',

            ],
            [
                'id' => 112,
                'title' => 'sub_product_type_delete',

            ],
            [
                'id' => 113,
                'title' => 'sub_product_type_show',

            ],
            [
                'id' => 114,
                'title' => 'sub_product_type_edit',

            ],
            [
                'id' => 115,
                'title' => 'main_product_service_type_create',

            ],
            [
                'id' => 116,
                'title' => 'main_product_service_type_access',

            ],
            [
                'id' => 117,
                'title' => 'main_product_service_type_delete',

            ],
            [
                'id' => 118,
                'title' => 'main_product_service_type_show',

            ],
            [
                'id' => 119,
                'title' => 'main_product_service_type_edit',

            ],
            [
                'id' => 120,
                'title' => 'sub_product_service_type_create',

            ],
            [
                'id' => 121,
                'title' => 'sub_product_service_type_access',

            ],
            [
                'id' => 122,
                'title' => 'sub_product_service_type_delete',

            ],
            [
                'id' => 123,
                'title' => 'sub_product_service_type_show',

            ],
            [
                'id' => 124,
                'title' => 'sub_product_service_type_edit',

            ],
            [
                'id' => 125,
                'title' => 'category_main_test_create',

            ],
            [
                'id' => 126,
                'title' => 'category_main_test_access',

            ],
            [
                'id' => 127,
                'title' => 'category_main_test_delete',

            ],
            [
                'id' => 128,
                'title' => 'category_main_test_show',

            ],
            [
                'id' => 129,
                'title' => 'category_main_test_edit',

            ],
            [
                'id' => 130,
                'title' => 'sub_category_main_test_create',

            ],
            [
                'id' => 131,
                'title' => 'sub_category_main_test_access',

            ],
            [
                'id' => 132,
                'title' => 'sub_category_main_test_delete',

            ],
            [
                'id' => 133,
                'title' => 'sub_category_main_test_show',

            ],
            [
                'id' => 134,
                'title' => 'sub_category_main_test_edit',

            ],
            [
                'id' => 135,
                'title' => 'news_category_main_test_create',

            ],
            [
                'id' => 136,
                'title' => 'news_category_main_test_access',

            ],
            [
                'id' => 137,
                'title' => 'news_category_main_test_delete',

            ],
            [
                'id' => 138,
                'title' => 'news_category_main_test_show',

            ],
            [
                'id' => 139,
                'title' => 'news_category_main_test_edit',

            ],
            [
                'id' => 140,
                'title' => 'news_sub_category_test_create',

            ],
            [
                'id' => 141,
                'title' => 'news_sub_category_test_access',

            ],
            [
                'id' => 142,
                'title' => 'news_sub_category_test_delete',

            ],
            [
                'id' => 143,
                'title' => 'news_sub_category_test_show',

            ],
            [
                'id' => 144,
                'title' => 'news_sub_category_test_edit',

            ],
            [
                'id' => 145,
                'title' => 'main_product_type_test_create',

            ],
            [
                'id' => 146,
                'title' => 'main_product_type_test_access',

            ],
            [
                'id' => 147,
                'title' => 'main_product_type_test_delete',

            ],
            [
                'id' => 148,
                'title' => 'main_product_type_test_show',

            ],
            [
                'id' => 149,
                'title' => 'main_product_type_test_edit',

            ],
            [
                'id' => 150,
                'title' => 'sub_product_type_test_create',

            ],
            [
                'id' => 151,
                'title' => 'sub_product_type_test_access',

            ],
            [
                'id' => 152,
                'title' => 'sub_product_type_test_delete',

            ],
            [
                'id' => 153,
                'title' => 'sub_product_type_test_show',

            ],
            [
                'id' => 154,
                'title' => 'sub_product_type_test_edit',

            ],
            [
                'id' => 155,
                'title' => 'sub_product_service_type_test_create',

            ],
            [
                'id' => 156,
                'title' => 'sub_product_service_type_test_access',

            ],
            [
                'id' => 157,
                'title' => 'sub_product_service_type_test_delete',

            ],
            [
                'id' => 158,
                'title' => 'sub_product_service_type_test_show',

            ],
            [
                'id' => 159,
                'title' => 'sub_product_service_type_test_edit',

            ],
        ];

        Permission::insert($permissions);
    }
}
