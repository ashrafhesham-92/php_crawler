<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 5:00 PM
 */

namespace App\Classes\Models;


class CrawledLinks extends Model
{

    /**
     * The model representing the crawled_links table in the database
     */


    /**
     * table name that model is connected to
     *
     * @var string
     */
    protected $table = 'crawled_links';

    /**
     * The query to be built for doing some action like insert
     *
     * @var string
     */
    private static $query = '';

    /**
     * Functions that saves data to the table based on the passed query
     *
     * @param string $sql
     * @param bool|false $multiquery
     * @return mixed
     */
    public function save(string $sql, bool $multiquery = false) : array
    {
        if($this->connection->multi_query(static::$query) === true)
        {
            static::$query = '';
            return [
                "status" => "success",
                "message" => "Crawled links saved successfully ..... "
            ];
        }
        else
        {
            static::$query = '';
            return [
                "status" => "fail",
                "message" => "Error saving crawled links! ({$this->connection->error})"
            ];
        }
    }

    /**
     * custom function to save the data of crawled links after preparing the query
     *
     * @param array $data
     */
    public function saveCrawledLinks(array $data)
    {
        $query = $this->prepareQuery($data);

        $save_result = $this->save($query, true);

        if($save_result['status'] == 'fail')
        {
            die($save_result['message']);
        }

        echo $save_result['message'];
    }

    /**
     * custom function to build the query to save all the crawled links
     *
     * @param array $data
     * @return string
     */
    public function prepareQuery(array $data) : string
    {
        /**
         * TODO: enhance the function so it can work with separate parts of data and save them,
         * because saving all of the records at once takes long time !
         */

        foreach($data as $level => $values)
        {
            /**
             * The first 2 levels 0 and 1 are special cases in the structure of them ..
             * level 0 has only the initial page that we start crawling from
             * level 1 has the sub links of the initial pages so it is NOT a multidimensional array
             *
             * but other levels are multidimensional so we need to loop 1 level deeper
             */
            switch($level)
            {
                case 0:
                    static::$query .= "insert into {$this->table} (tree_level, parent_index, link_index, link) values ({$level}, null, null, '{$values}');";
                    break;
                case 1:
                    foreach($values as $link_index => $link)
                    {
                        static::$query .= "insert into {$this->table} (tree_level, parent_index, link_index, link) values ({$level}, 0, {$link_index}, '{$link}');";
                    }
                    break;
                default:
                    foreach($values as $parent_index => $links)
                    {
                        foreach($links as $link_index => $link)
                        {
                            static::$query .= "insert into {$this->table} (tree_level, parent_index, link_index, link) values ({$level}, {$parent_index}, {$link_index}, '{$link}');";
                        }
                    }
                    break;
            }
        }

        return static::$query; // return the complete query that inserts all records
    }
}