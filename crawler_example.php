<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 1:53 PM
 */

/**
 * example to test the application
 */

require "vendor/autoload.php";

use App\Classes\Crawler;

try
{
    require_once('index.php');

    $base_url = $config['app']['base_url'];
    $initial_page = $config['app']['initial_page'];

    $crawler = new Crawler($base_url);

//    $result = $crawler->crawl($initial_page, 1); // this takes to much time for building the three tree levels of links 0 , 1 and 2
    $result = $crawler->crawl($initial_page); // only build tree with initial levels 0 and 1

    echo json_encode($result); // prints the crawled links tree as json string so it can be viewed in a JSON viewer
}
catch(\Exception $e)
{
    die($e->getMessage());
}