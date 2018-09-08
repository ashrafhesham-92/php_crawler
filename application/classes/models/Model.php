<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 4:54 PM
 */

namespace App\Classes\Models;

use App\Classes\DatabaseDrivers\MysqlDriver;
use App\Interfaces\DatabaseDriverInterface;
use App\Interfaces\ModelInterface;

class Model implements ModelInterface
{

    /**
     * The base class for models , it contains the connection required to make operations
     */

    /**
     * The database connection that will be used to make operations
     *
     * @var
     */
    protected $connection;

    public function __construct()
    {
        $db_driver = $GLOBALS['active_database_driver']; // gets the active database driver
        $this->connection = $db_driver->getConnection(); // gets the database connection from the active driver
    }

    /**
     * Base function for saving data
     *
     * @param string $sql
     * @param bool|false $multiquery
     * @return mixed
     */
    public function save(string $sql, bool $multiquery = false) : array
    {
        // todo .. implement insert data logic
    }

    // todo .. implement more functions
}