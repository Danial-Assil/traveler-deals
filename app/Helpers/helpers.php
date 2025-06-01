<?php

if (!function_exists('is_active')) {
    function is_active(string $routeName,$segment=2)
    {
        if($routeName == 'home' && request()->segment($segment)==null)
            return true;
        return null !== request()->segment($segment) && request()->segment($segment) == $routeName ? true : false;
    }
}
