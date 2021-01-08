<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\Coupon;
use App\Models\Permission;

class CityRepository
{

    /**
     * check if it has relation in other model before deleting
     * @param $city
     */
    public function checkForExistenceInOtherModel(City $city)
    {
        $check = 0;

        if ($city->cityDepartments()->exists() || $city->cityProducts()->exists()
            || $city->cityNews()->exists() || $city->cityOffers()->exists() ||
            $city->cityJobOffers()->exists() ||
            $city->cityNotifications()->exists()) {
            $check = 1;
        }
        return $check;
    }
}
