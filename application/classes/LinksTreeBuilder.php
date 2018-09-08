<?php

/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 1:38 AM
 */

namespace App\Classes;

use App\Interfaces\LinksTreeBuilderInterface;
use App\Classes\Models\CrawledLinks;

class LinksTreeBuilder implements LinksTreeBuilderInterface
{

    /**
     * The purpose of this class is to build a tree like array of links that are crawled from the website under action
     *
     * I thought how to build it and the idea is as follows :
     *
     * we have an array that called "tree" and a "pointer"
     * the basic indexes of the tree act as the levels of a real tree so,
     * tree[0] represents level 0 of the tree
     * tree[1] represents levels 1 which is the child of level 0
     * tree[2] represents level 2 which is the child of level 1 and so on....
     *
     * levels 0 and 1 are special cases :
     * level 0 : has onl the initial link that we started crawling from (tree[0] = 'website.com/initialPage')
     * level 1 : has only array of child links under level 0 (tree[1] = [0 => sub link 1 , 1 => sub link 2])
     *
     * the other levels should have the same structure as multidimensional arrays as follows :
     * tree[2][0] = [0 => sub link 1 , 1 => sub link 2]
     * tree[2][1] = [0 => sub link 1 , 1 => sub link 2]
     * .. here the [0] and [1] indexes represents the [0] and [1] indexes of the parent level (level 1)
     * this means that tree[2][0] is branched from tree[1][0]
     * and tree[2][1] is branched from tree[1][1]
     *
     * This is how the tree of links and sub links is build
     */


    /**
     * Array that holds the tree to be built
     * @var array
     */
    protected $tree = [];

    /**
     * the pointer is used to point to the tree levels to build it
     * initially points at level 0
     * @var int
     */
    protected $pointer = 0;

    /**
     * object of the html dom parser class to help us get specific elements from the web page
     *
     * @var null|static
     */
    private $simple_html_dom_helper = null;

    /**
     * The base URL of the website we will crawl
     * @var string
     */
    private $base_url;

    /**
     * object of CrawledLinks model that will be used to save the crawled links to the database
     * @var
     */
    private static $crawled_links_model;

    public function __construct(string $base_url)
    {
        $this->simple_html_dom_helper = SimpleHtmlDomHelper::_initialize();
        $this->base_url = $base_url;
        static::$crawled_links_model = new CrawledLinks();
    }

    /**
     * Gets the final built tree of links and sub links
     *
     * @return mixed
     */
    public function getTree() : array
    {
        return $this->tree;
    }

    /**
     * Function to handle building tree operation in its correct sequence
     *
     * @param string $initial_page
     * @param int $max_level_to_build_children_for
     * @return LinksTreeBuilderInterface
     */
    function buildLinksTree(string $initial_page, int $max_level_to_build_children_for = 0) : LinksTreeBuilderInterface
    {
        $this->buildInitialLevels($initial_page); // builds the intiial levels of the tree which are levels 0 and 1

        /**
         * if user wants to build extra levels we go to the build extra levels function
         */
        if($max_level_to_build_children_for > 0)
        {
            $this->buildExtraLevels($max_level_to_build_children_for);
        }

        // insert generated links tree to database
        static::$crawled_links_model->saveCrawledLinks($this->tree);
        return $this;
    }

    /**
     * A function that builds the initial levels (level 0 and level 1) of the links tree.
     * level 0 in the base node of the tree that only contains the initial page link
     * level 1 is the children nodes of the base node
     *
     * the 2 levels are considered as initial levels because they are the base of the tree,
     * and depending on them we can build up the tree to any level we want
     *
     * @param string $initial_page
     * @return LinksTreeBuilderInterface
     */
    function buildInitialLevels(string $initial_page) : LinksTreeBuilderInterface
    {
        $this->tree[$this->pointer] = $this->base_url.$initial_page;

        $child_links = $this->simple_html_dom_helper->getChildLinks($this->base_url.$initial_page);
        $this->tree[++$this->pointer] = $child_links;

        return $this;
    }

    /**
     * A function that builds the extra levels of the tree based on the initial levels.
     * The extra levels are built depending on a maximum level also.
     * So if the function called with max_level = 1 , the children of level 1 will be built and no more.
     * But if function called with max_level = 2 , children of both levels 1 and 2 will be built in the tree.
     *
     * @param int $max_level_to_build_children_for
     * @return LinksTreeBuilderInterface
     */
    function buildExtraLevels(int $max_level_to_build_children_for) : LinksTreeBuilderInterface
    {
        if($this->pointer == 1) // if pointer points to level#1 we build level#2 by default so we can continue building tree levels recursively
        {
            foreach($this->tree[$this->pointer] as $level_one_link)
            {
                $child_links = $this->simple_html_dom_helper->getChildLinks($this->base_url.$level_one_link);
                $this->tree[$this->pointer + 1][] = $child_links;
            }

            $this->pointer++; // pointer now points to level#2

            if($this->pointer > $max_level_to_build_children_for) // if pointer is already pointing to the children level and we don't need to go for extra levels we just return the object
            {
                return $this;
            }

            return $this->buildExtraLevels($max_level_to_build_children_for); // if we need to build extra levels we call the function again
        }
        else
        {
            foreach($this->tree[$this->pointer] as $level_links)
            {
                foreach($level_links as $link)
                {
                    $child_links = $this->simple_html_dom_helper->getChildLinks($this->base_url.$link);
                    $this->tree[$this->pointer + 1][] = $child_links;
                }
            }

            $this->pointer++;

            if($this->pointer > $max_level_to_build_children_for) // if pointer is already pointing to the children level and we don't need to go for extra levels we just return the object
            {
                return $this;
            }

            return $this->buildExtraLevels($max_level_to_build_children_for); // if we need to build extra levels we call the function again
        }
    }
}