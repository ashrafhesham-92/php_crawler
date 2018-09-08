<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 4:32 PM
 */

namespace App\Interfaces;


interface DatabaseDriverInterface
{
    static function _initialize(string $server, string $username, string $password, string $db) : DatabaseDriverInterface;
    static function connect();
    static function disconnect() : bool;
    function getConnection() : ?\mysqli;
}