<?php

if (!function_exists('compareIsEqualArray')) {
    function compareIsEqualArray(array $array1, array $array2): bool {
        return (array_diff($array1, $array2) == [] && array_diff($array2, $array1) == []);
    }
}
