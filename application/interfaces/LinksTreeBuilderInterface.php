<?php

/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 9/8/2018
 * Time: 1:30 AM
 */

namespace App\Interfaces;

interface LinksTreeBuilderInterface
{
    /**
     * Builds the initial levels of tree ( level 0 and level 1) based on the initial page provided to it
     * @return mixed
     */
    function buildInitialLevels(string $initial_page) : LinksTreeBuilderInterface;

    /**
     * Builds extra levels of tree on purpose
     * @return mixed
     */
    function buildExtraLevels(int $max_level_to_build_children_for) : LinksTreeBuilderInterface;

    function getTree() : array;
}