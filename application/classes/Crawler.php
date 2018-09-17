<?php

namespace App\Classes;

use App\Interfaces\LinksTreeBuilderInterface;

class Crawler
{

    /**
     * This class is the entry point to start crawling the website pages links
     * It has only the crawl() function and all of the logic is done by calling it only
     */

    /**
     * The base URL of the website that we need to crawl its pages
     *
     * @var string
     */
    private $base_url;

    /**
     * The tree builder object that will be used to get the crawled data
     *
     * @var LinksTreeBuilder
     */
    private $links_tree_builder;

    /**
     * holds hierarhy of trees of link and its sub links when we change the "page" parameter in the link
     *
     * @var array
     */
    private static $multi_trees = [];

    public function __construct(string $base_url)
    {
        $this->base_url = $base_url;
        $this->links_tree_builder = new LinksTreeBuilder($base_url);
    }

    /**
     * This function accepts the initial page that we will start crawling from ,
     * and the maximum level we want to get children for which is by default 0
     *
     * when we say we want to get children for level 0 as maximum the result will be returned containing both 0 and 1 levels
     * but when we say we want to get children for level 2 as maximum , we will have levels 0, 1, 2 and 3
     *
     * @param string $initial_page
     * @param int $max_level_to_build_children_for
     * @return mixed
     */
    public function crawl(string $initial_page, $max_level_to_build_children_for = 0) : array
    {
        return $this->links_tree_builder->buildLinksTree($initial_page, $max_level_to_build_children_for)->getTree();
    }

    public function crawlWithPagesParam(string $page_url, string $page_param_name = 'ep', int $start_with_page = 1, int $max_page = 2)
    {
        $this->links_tree_builder = new LinksTreeBuilder($this->base_url);
        $url = $page_url."?$page_param_name=$start_with_page";
        
        if($start_with_page > $max_page)
        {
            return static::$multi_trees;
        }

        static::$multi_trees[] = $this->links_tree_builder->buildLinksTree($url, 0)->getTree();
        
        return $this->crawlWithPagesParam($page_url, $page_param_name, ++$start_with_page, $max_page);
    }
}