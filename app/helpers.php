<?php

use App\Helpers\General\Timezone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/*
 * Global helpers file with misc functions.
 */

if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone()
    {
        return resolve(Timezone::class);
    }
}

if (!function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('parse_phone_number')) {

    /**
     * For International Number Parsing
     *
     * @param string $number
     * @return string
     */
    function parse_phone_number($number)
    {
        $count = strlen($number);
        if ($count >= 10 && Str::startsWith($number, "959")) {
            return Str::after($number, "959");
        } elseif ($count >= 9 && Str::startsWith($number, "09")) {
            return Str::after($number, "09");
        } else {
            return $number;
        }
    }
}

if (!function_exists('camelcase_to_word')) {

    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (!function_exists('loginUser')) {
    function loginUser()
    {
        return Auth::guard('employee')->user();
    }
}
