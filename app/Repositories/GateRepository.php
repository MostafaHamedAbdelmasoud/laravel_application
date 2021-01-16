<?php


namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Product;

class GateRepository
{
    /**
     * store the current user
     *
     * @var
     */
    public $user;
    /**
     * store the current user
     *
     * @var
     */
    public $checkNull;

    /**
     * get all permissions of auth user
     *
     * @return array
     */
    public function get_permissions()
    {
        $roles = $this->user->roles;

        $permissions = [];

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->title;
            }
        }

        return $permissions;
    }

    /**
     * get name of gate if in roles
     *
     * @param array $parameters
     * @param $type
     * @param $suffix
     * @return string
     */
    public function get_gate(array $parameters, $type, $suffix)
    {
        $permissions = $this->get_permissions();

        foreach ($parameters as $parameter) {
            $imploded_parameter = implode('_', explode(' ', $parameter));

            if (in_array($imploded_parameter . $suffix, $permissions)) {
                return $type . $suffix;
            }
        }
        return '';
    }
}
