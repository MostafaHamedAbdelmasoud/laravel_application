<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();
        if ($user) {
            $roles = Role::with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

//        dd($roles->first()->permissions->first());
//        dd(User::where('name','mostafa')->first()->roles->first()->permissions()->orderBy('id')->get());

            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function ($user) use ($roles, $title) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0 ||
                        $this->checkPermission($user, $title);
                });
            }
        }

        return $next($request);
    }

    public function checkPermission($user, $title)
    {
        foreach ($user->roles as $role) {
            $permissions = $role->permissions->pluck('title');
            $arrs = explode('_', $title);
            foreach ($arrs as $ar) {
                return strstr($permissions, $ar);
            }
        }
        return false;
    }
}
