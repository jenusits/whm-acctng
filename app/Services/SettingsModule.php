<?php

namespace App\Services;

use \App\Settings;

class SettingsModule
{
    //
    public static function set($key, $value = "", $dataType = 'text', $show = false) {
        $setting = Settings::where('key', $key)->first();

        if ($setting == null) {
            $setting = new Settings;    
            $setting->key = str_replace(' ', '_', strtolower($key));
        }

        $setting->value = json_encode($value);
        if ($dataType != null)
            $setting->data_type = $dataType;

        $setting->show = $show;
        $setting->save();
    }

    public static function get($key, $default_value = '') {
        if (Settings::where('key', $key)->first()) {
            $setting = Settings::where('key', $key)->first();
            return json_decode($setting->value);
        } else
            return $default_value;
    }

    public static function forget($key) {
        $setting = Settings::where('key', $key)->first();

        if ($setting != null) {
            $setting->delete();
            return true;
        } else
            return false;
    }

    public static function all() {
        return Settings::all();
    }
}
