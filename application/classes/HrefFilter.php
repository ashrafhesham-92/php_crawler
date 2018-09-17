<?php

/**
 * User: Ash
 * Date: 9/17/2018
 * Time: 7:59 PM
 */

 namespace App\Classes;

 abstract class HrefFilter
 {
     protected $anchors;
     public $filteredHrefs = [];

     final public function __construct(array $anchors)
     {
         $this->anchors = $anchors;

         $this->filter();
     }

     private function filter()
     {
         foreach($this->anchors as $anchor)
         {
             if($anchor->href !== null)
             {
                 if($this->valid_href($anchor->href))
                 {
                     $this->filteredHrefs[] = $anchor->href;
                 }
             }
         }
     }

     abstract function valid_href(string $href) : bool;
 }