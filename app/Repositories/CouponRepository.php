<?php


namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{
    /**
     * create model
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        if ($data['type'] == 'percentage_discount') {
            unset($data['fixed_discount']);
        } else {
            unset($data['percentage_discount']);
        }
        return Coupon::create($data);
    }

    /**
     * Display the given client instance.
     *
     * @param mixed $model
     * @return Coupon
     */
    public function find($model)
    {
        if ($model instanceof Coupon) {
            return $model;
        }

        return Coupon::findOrFail($model);
    }


    /**
     * update model
     *
     * @param array $data
     * @return mixed
     */
    public function update($model, array $data)
    {
        $coupon = $this->find($model);

        if ($data['type'] == 'percentage_discount') {
            $data['fixed_discount'] = null;
        } else {
            $data['percentage_discount'] = null;
        }

        $coupon->update($data);

        return $coupon;
    }
}
