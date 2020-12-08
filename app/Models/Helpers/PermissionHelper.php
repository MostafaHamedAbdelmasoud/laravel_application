<?php

namespace App\Models\Helpers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermissionHelper
{
    public static function createPermissionWithModelAttribute($attribute)
    {
        $permission_sufixs = [
            '_create',
            '_edit',
            '_show',
            '_delete',
            '_access',
        ];
        $attribute_Array = explode(' ', $attribute);
        $attribute_seperated = implode('_', $attribute_Array);

        foreach ($permission_sufixs as $permission_suffix) {
            $permission = Permission::create([
                'title' => $attribute_seperated . $permission_suffix,
            ]);
            $lol = Role::where('title', 'Admin')->first()->permissions()->attach($permission);
//            dd($lol);
        }

        DB::beginTransaction();
        try {
            $permissions = Permission::pluck('title', 'id');

            $path = base_path() . '/resources/lang/ar/permissions.php';
            $path_of_permissions_of_main_components = base_path() . '/resources/lang/ar/permissions_of_main_components.php';
            $explodes = explode("=>", file_get_contents($path_of_permissions_of_main_components));
            $cnt_of_permission_copy = count($explodes) - 1;

            $content = "<?php\n\nreturn\n[\n";

            foreach ($permissions as $key => $permission) {
                if ($key <= $cnt_of_permission_copy) {
                    $content .= "\t'" . $permission . "' => '" . trans('permissions_of_main_components.' . $permission) . "',\n";
                } else {

                    $content .= "\t'" . $permission . "' => '" . trans('permissions.' . $permission) . "',\n";
                }
            }

            $content .= "\t'" . $attribute_seperated . '_create' . "' => '" . $attribute .' ' . trans('global.add') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_edit' . "' => '" . $attribute .' ' . trans('global.edit') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_show' . "' => '" . $attribute .' ' . trans('global.show') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_delete' . "' => '" . $attribute .' ' . trans('global.delete') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_access' . "' => '" . $attribute .' ' . trans('global.access') . "',\n";
            // }

            $content .= "];";

            file_put_contents($path, $content);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            var_dump($e->getMessage());
        }
    }
}
