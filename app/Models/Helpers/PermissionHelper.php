<?php

namespace App\Models\Helpers;

use App\Models\Permission;
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
        foreach ($permission_sufixs as $permission_sufix) {
            Permission::create([
                'title' => $attribute_seperated . $permission_sufix,
            ]);
        }

        DB::beginTransaction();
        try {

            $permissions = Permission::pluck('title','id');

            $path = base_path() . '/resources/lang/ar/permissions.php';

            $content = "<?php\n\nreturn\n[\n";

            foreach ($permissions as $key => $permission) {
                if($key>124) break;
                $content .= "\t'" . $permission . "' => '" . trans('permissions_copy.'.$permission)  . "',\n";
            }

            $content .= "\t'" . $attribute_seperated . '_create' . "' => '" .  $attribute_seperated . '_' . trans('global.add') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_edit' . "' => '" .  $attribute_seperated . '_' . trans('global.edit') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_show' . "' => '" .  $attribute_seperated .  '_' . trans('global.show') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_delete' . "' => '" .  $attribute_seperated .  '_' . trans('global.delete') . "',\n";
            $content .= "\t'" . $attribute_seperated . '_access' . "' => '" .  $attribute_seperated .  '_' . trans('global.access') . "',\n";
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
