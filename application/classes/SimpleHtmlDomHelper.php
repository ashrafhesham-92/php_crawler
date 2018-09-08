<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 1:42 AM
 */

namespace App\Classes;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\CurlException;

class SimpleHtmlDomHelper
{
    /**
     * Class that make it easy to extract elements from the web page and have functions to filter the links
     *
     * the PHPHtmlParser\Dom is used to extract elements
     */


    private static $dom_parser = null;

    private function __construct(){}

    /**
     * initialize a single object of the class
     * @return static
     */
    public static function _initialize()
    {
        static $instance = null; // declared static for the purpose of not loosing its value when execution leaves the function scope
        static::$dom_parser = new Dom();

        if($instance === null)
        {
            $instance = new static;
        }

        return $instance;
    }

    /**
     * A function that returns array of child hrefs of the base link provided to it
     *
     * @param string $base_link
     * @return mixed
     * @throws Exception
     */
    public function getChildLinks(string $base_link) : array
    {
        try
        {
            $link_content = static::$dom_parser->loadFromUrl($base_link);

            $hrefs = $this->getFilteredHrefs($link_content->find('a')->toArray());

            return $hrefs;
        }
        catch(CurlException $c_e)
        {
            die($c_e->getMessage());
        }
        catch(\Exception $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * This function is used to return filtered internal href from the provided anchor objects
     *
     *
     * @param array $anchors
     * @return mixed
     */
    protected function getFilteredHrefs(array $anchors) : array
    {
        $filtered_hrefs = [];

        foreach($anchors as $anchor)
        {
            if($anchor->href !== null)
            {
                if($this->validHref($anchor->href))
                {
                    $filtered_hrefs[] = $anchor->href;
                }
            }
        }

        return $filtered_hrefs;
    }

    /**
     * The purpose of this function is to make sure the href is valid based on th e following criteria :
     * - the first character of it is '/' , because I noticed that the internal links of website pages ..
     * are beginning with the '/' character , otherwise they are mostly external links referring ot other websites
     *
     * - the link dose not include the '#' character to make sure that it is not referring to a modal or something like that
     *
     * ### THIS IS SPECIFIC FOR THE PROVIDED WEBSITE ###
     *
     * @param string $href
     * @return bool
     */
    protected function validHref(string $href) : bool
    {
        if($href[0] === '/' && strpos($href, '#') === false)
        {
            return true;
        }

        return false;
    }
}