<?php

/**
 * User: Ash
 * Date: 9/17/2018
 * Time: 8:03 PM
 */

 namespace  App\Classes;

 class BasicHrefFilter extends HrefFilter
 {
     function valid_href(string $href) : bool
     {
        if($href[0] === '/' && strpos($href, '#') === false)
        {
            return true;
        }

        return false;
     }
 }