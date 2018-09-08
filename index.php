<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 10:40 PM
 */
use App\Classes\DatabaseDrivers\DatabaseDriverRegistrer;

$config = require_once('config.php');

$GLOBALS['config'] = $config; // sets the config as global variable to be used anywhere in the app

DatabaseDriverRegistrer::_initialize()->register(); // registering the default database driver to be used in the app

