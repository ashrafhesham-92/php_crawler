<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 10:31 PM
 */

namespace App\Classes\DatabaseDrivers;


class DatabaseDriverRegistrer
{

    /**
     * The purpose of this class is to check what database driver is to be used in the application
     * and register it as global variable in the application to be used for any database operation
     */


    const MYSQL = 'mysql'; // constant define the name of the mysql driver

    private function __construct(){}

    /**
     * initializing single object of the class
     *
     * @return static
     */
    public static function _initialize()
    {
        static $instance = null;

        if($instance === null)
        {
            $instance = new static;
        }

        return $instance;
    }

    /**
     * Registers the database driver based on the driver name set in the config
     *
     * @return void
     */
    public function register() : void
    {
        $database_config = $GLOBALS['config']['db'];

        switch($database_config['driver'])
        {
            case static::MYSQL:
                $this->registerMysql($database_config);
                break;
            default:
                // handle registering another kind
                break;
        }
    }

    /**
     * Registers the mysql database driver
     *
     * @param array $database_config
     */
    private function registerMysql(array $database_config) : void
    {
        $GLOBALS['active_database_driver'] = MysqlDriver::_initialize(
            $database_config['server'],
            $database_config['username'],
            $database_config['password'],
            $database_config['database_name']
        );
    }
}