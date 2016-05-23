<?php
/**
 * Created by PhpStorm.
 * User: mgcum
 * Date: 3/26/2016
 * Time: 2:51 PM
 */
namespace NestSet;

/**
 * Interface NestedSetInterface
 */
interface NestedSetInterface
{
    public function getAncestor();
    public function getAncestors();
        /**
     * Used to get a list(array) of the node's ancestors.
     *
     * NOTE: This method will only return the immediate ancestor of the node by default. To get any additional levels of
     * the ancestors $levelsAbove > maximum levels above but not more then PHP_INT_MAX should be used.
     *
     * @param int    $levelsAbove Determines how many ancestor level(s) above should be included relative to the node.
     * @param string $sort        Determines sorting of the ancestor list. Value is case insensitive.
     *                            'asc' (ascending): From root node to immediate ancestor.
     *                            'desc' (descending): From immediate ancestor to root node.
     *
     * @return NodeInterface[] Returns array of ancestor node(s). Root node will return empty array.
     */
    public function getAncestorList($levelsAbove = 1, $sort = 'asc');
    /**
     * Check if node has any ancestor(s).
     *
     * @return bool Normally only a root node will return false.
     */
    public function hasAncestors();
}
