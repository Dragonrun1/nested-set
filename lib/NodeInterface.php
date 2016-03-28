<?php
/**
 * Created by PhpStorm.
 * User: mgcum
 * Date: 3/26/2016
 * Time: 2:59 PM
 */
namespace NestSet;

/**
 * Interface NodeInterface
 */
interface NodeInterface
{
    /**
     * Add a new direct descendant node to the current node.
     *
     * NOTE: If integer $value is >= descendant count then it will act like 'last' would.
     *
     * @param NodeInterface $node  New descendant node to be added.
     * @param int|string $value    Relative position in descendant list with negative integers counting from last
     *                             position. Integer value MUST BE between PHP_INT_MIN and PHP_INT_MAX. The case
     *                             insensitive string value MUST BE 'first' or 'last' which causes the new descendant
     *                             node to take over the corresponding position.
     *
     * @return self Fluent interface.
     */
    public function addDescendantByPosition(NodeInterface $node, $value = 'last');
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
     * Use to get count of descendant nodes.
     *
     * NOTE: This method will only return a count of the direct descendants from the node by default and NOT any
     * additional levels of descendants. If you need all the descendants of a node whether or not they have intervening
     * ancestors you MUST set $levelsBelow > maximum levels below but not more than PHP_INT_MAX.
     *
     * @param int $levelsBelow
     *
     * @return int Returns number of descendant nodes.
     */
    public function getDescendantCount($levelsBelow = 1);
    /**
     * Used to get a list(array) of the node's descendants.
     *
     * NOTE: This method will only return a list of the direct descendants from the node by default and NOT any
     * additional levels of descendants. If you need all the descendants of a node whether or not they have intervening
     * ancestors you MUST set $levelsBelow > maximum levels below but not more than PHP_INT_MAX.
     *
     * @param int    $levelsBelow Determines how many levels of descendants relative to the node should be included.
     * @param string $sort        Determines sorting of the descendant list. Value is case insensitive.
     *                            'asc' (ascending): From first to last descendant.
     *                            'desc' (descending): From last to first descendant.
     *
     * @return NodeInterface[] Returns array of descendant node(s). Will return empty array if node has no descendants.
     */
    public function getDescendantList($levelsBelow = 1, $sort = 'asc');
    /**
     * Retrieve node's nested set left value.
     *
     * @return int
     */
    public function getLeft();
    /**
     * Retrieve node's nested set level value.
     *
     * @return int
     */
    public function getLevel();
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     */
    public function getRight();
    /**
     * Check if node has any ancestor(s).
     *
     * @return bool Normally only a root node will return false.
     */
    public function hasAncestors();
    /**
     * Check if node has any descendant(s).
     *
     * @return bool
     */
    public function hasDescendants();
    /**
     * Remove an existing descendant node referenced by it's left value.
     *
     * @param int $value Use left nested set value to find descendant.
     *
     * @return NodeInterface Returns the removed descendant node.
     * @throws \DomainException Throws exception if $value isn't an existing descendant node.
     */
    public function removeDescendantByLeft($value);
    /**
     * Remove an existing descendant node referenced by it's position.
     *
     * @param int|string $value Relative position in descendant list. Integer value MUST BE between 0 and PHP_INT_MAX.
     *                          The case insensitive string value MUST BE 'first' or 'last' which causes the existing
     *                          descendant node to be removed from the corresponding position.
     *
     * @return NodeInterface Returns the removed descendant node.
     * @throws \DomainException Throws exception if an existing descendant node doesn't exist for the $value position.
     */
    public function removeDescendantByPosition($value);
}
