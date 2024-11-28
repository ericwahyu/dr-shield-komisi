<?php

namespace App\Traits;

use App\Models\System\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

trait GetSystemSetting
{
    public static function getSystemSetting()
    {
        $system_setting = Cache::rememberForever('setting_cache', function () {
            $columns = Schema::getColumnListing('system_settings');
            $desiredColumns = array_diff($columns, ['id', 'deleted_at', 'created_at', 'updated_at']);

            return SystemSetting::select($desiredColumns)->first();
        });

        return $system_setting;
    }
}
