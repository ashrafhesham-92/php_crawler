<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 4:58 PM
 */

namespace App\Interfaces;


interface ModelInterface
{
    public function save(string $sql, bool $multiquery = false) : array;
}