<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 6:20 PM
 */

/**
 * The application basic configuration
 */

return[
    'db' => [
        'driver' => 'mysql',
        'server' => 'localhost',
        'username' =>  'root',
        'password' => '123',
        'database_name' => 'crawler'
    ],
    'app' => [
        'base_url' => 'https://www.homegate.ch',
        'initial_page' => '/mieten/immobilien/kanton-zuerich/trefferliste',
        'url_filter_method' => 'with_id', // normal or with_id,
        'crawling_method' => 'with_page_param', // normal or with_page_param
    ]
];