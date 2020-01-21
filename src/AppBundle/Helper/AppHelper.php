<?php


namespace AppBundle\Helper;


class AppHelper
{

    public static function sameArrays(array $array1, array $array2)
    {
        return is_array($array1) and is_array($array2) and count($array1) == count($array2) and array_diff($array1, $array2) == array_diff($array2, $array1);
    }
}