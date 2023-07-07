<?php

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return auth()->user()->hasPermission($permission);
    }
}
