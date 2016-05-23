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
     * Retrieve node's payload value.
     *
     * @return mixed
     */
    public function getPayload();
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     */
    public function getRight();
    /**
     * Check if node has any descendant(s).
     *
     * @return bool
     */
    public function hasDescendants();
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
    /**
     * Sets descendents list.
     *
     * @param NodeInterface[] $value Array of NodeInterfaces.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if any of the values are NOT NodeInterfaces.
     */
     public function setDescendants(array $value = []);
    /**
     * Sets nested set left value.
     *
     * @param int $value Value for left.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if $value > PHP_INT_MAX - 1.
     */
    public function setLeft($value);
    /**
     * Sets payload value.
     *
     * @param mixed $value Value of the payload that this NodeInterface is for.
     *
     * @return self Fluent interface.
     */
     public function setPayload($value);
}
