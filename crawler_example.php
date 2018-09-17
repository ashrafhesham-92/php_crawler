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


require_once('index.php');

use App\Classes\Crawler;

// $str = "hello/man/123";
// $exploded = explode('/', $str);
// var_dump(end($exploded));die;

try
{
    $base_url = $config['app']['base_url'];
    $initial_page = $config['app']['initial_page'];

    $crawler = new Crawler($base_url);

    switch($config['app']['crawling_method'])
    {
        case 'normal':
        //    $result = $crawler->crawl($initial_page, 1); // this takes to much time for building the three tree levels of links 0 , 1 and 2
        $result = $crawler->crawl($initial_page); // only build tree with initial levels 0 and 1
        break;
        case 'with_page_param':
        $result = $crawler->crawlWithPagesParam($initial_page);
        break;
        default:
        //    $result = $crawler->crawl($initial_page, 1); // this takes to much time for building the three tree levels of links 0 , 1 and 2
        $result = $crawler->crawl($initial_page); // only build tree with initial levels 0 and 1
        break;
    }

    echo json_encode($result); // prints the crawled links tree as json string so it can be viewed in a JSON viewer
}
catch(\Exception $e)
{
    die($e->getMessage());
}