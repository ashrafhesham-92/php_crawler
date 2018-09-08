<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 4:35 PM
 */

namespace App\Classes\DatabaseDrivers;

use App\Interfaces\DatabaseDriverInterface;

class MysqlDriver implements DatabaseDriverInterface
{
    /**
     * The class that handles the connection initialization and destruction for the Mysql database driver
     */

    /**
     * mysql database server
     * @var string
     */
    protected static $server;

    /**
     * mysql database username
     * @var string
     */
    protected static $username;

    /**
     * mysql database password
     * @var string
     */
    protected static $password;

    /**
     * mysql database to connect to
     * @var string
     */
    protected static $db;

    /**
     * mysql connection
     * @var \mysqli|null
     */
    public static $connection = null;

    /**
     * Initializing single object of mysql driver
     *
     * @param string $server
     * @param string $username
     * @param string $password
     * @param string $db
     * @return DatabaseDriverInterface
     */
    public static function _initialize(string $server, string $username, string $password, string $db) : DatabaseDriverInterface
    {
        static $instance = null;

        if($instance === null)
        {
            $instance = new static;
        }

        static::$server = $server;
        static::$username = $username;
        static::$password = $password;
        static::$db = $db;

        // initialize connection on the creation of the driver
        $connection = static::connect();
        if(!$connection)
        {
            throw new \mysqli_sql_exception('Cannot connect to the database ('.static::$connection->connect_error);
        }

        static::$connection = $connection;

        return $instance;
    }

    /**
     * close database connection when object destruct
     */
    function __destruct()
    {
        static::$connection->close();
    }

    /**
     * create a mysqli connection object
     *
     * @return \mysqli
     */
    static function connect()
    {
        return mysqli_connect(static::$server, static::$username, static::$password, static::$db);
    }

    /**
     * close mysqli connection
     *
     * @return bool
     */
    static function disconnect() : bool
    {
        return static::$connection->close();
    }

    /**
     * returns the mysqli connection object
     *
     * @return \mysqli|null
     */
    function getConnection() : ?\mysqli
    {
        return static::$connection;
    }
}