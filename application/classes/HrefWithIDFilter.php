<?php

/**
 * User: Ash
 * Date: 9/17/2018
 * Time: 8:45 PM
 */

 namespace App\Classes;

 class HrefWithIDFilter extends HrefFilter
 {   
     function valid_href(string $href) : bool
     {
         $explodedHref = explode('/', $href);

         if(is_numeric(end($explodedHref)))
         {
             return true;
         }

         return false;
     }
 }