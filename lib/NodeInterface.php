<?php
/**
 * Contains interface NodeInterface.
 *
 * PHP version 5.5
 *
 * LICENSE:
 * This file is part of the Nested-Set library.
 * Copyright (C) 2016 Michael Cummings
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * You should be able to find a copy of this license in the LICENSE.md file. A
 * copy of the GNU GPL should also be available in the GNU-GPL.md file.
 *
 * @copyright 2016 Michael Cummings
 * @license   LGPL-3.0+
 * @author    Michael Cummings <mgcummings@yahoo.com>
 * @since 0.0.1
 */
namespace NestSet;

/**
 * Interface NodeInterface
 */
interface NodeInterface
{
    /**
     * Used to check if automatic updating of nesting values is set.
     *
     * @return boolean
     * @api
     */
    public static function isAutoNest();
    /**
     * Setter for static property used to determine if nesting values should be updated automatically.
     *
     * @param boolean $value
     *
     * @api
     */
    public static function setAutoNest($value = false);
    /**
     * Add a new direct descendant node to the current node.
     *
     * @param NodeInterface $node     New descendant node to be added.
     * @param string        $position Relative position in descendant list. The case insensitive string value which MUST
     *                                BE either 'first' or 'last' which causes the new descendant node to be added in
     *                                the corresponding position in the list.
     *
     * @return self Fluent interface.
     * @api
     */
    public function addDescendant(NodeInterface $node, $position = 'last');
    /**
     * Use to get count of descendant nodes.
     *
     * @return int Returns number of descendant nodes.
     * @api
     */
    public function getDescendantCount();
    /**
     * Used to get a list(array) of the node's descendants.
     *
     * @return NodeInterface[] Returns array of descendant node(s). Will return empty array if node has no descendants.
     * @api
     */
    public function getDescendants();
    /**
     * Retrieve node's nested set left value.
     *
     * @return int
     * @api
     */
    public function getLeft();
    /**
     * Retrieve node's nested set level value.
     *
     * @return int
     * @api
     */
    public function getLevel();
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     * @api
     */
    public function getRight();
    /**
     * Check if node has any descendant(s).
     *
     * @return bool
     * @api
     */
    public function hasDescendants();
    /**
     * Remove an existing descendant node referenced by it's position.
     *
     * @param string $position Relative position in descendant list. The case insensitive string value MUST BE 'first'
     *                         or 'last' which causes the existing descendant node to be removed from the corresponding
     *                         position.
     *
     * @return NodeInterface|null Returns the removed descendant node or NULL if nothing is removed.
     * @api
     */
    public function removeDescendant($position = 'last');
    /**
     * Sets descendants list.
     *
     * @param NodeInterface[] $value Array of NodeInterfaces.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if any of the values are NOT NodeInterfaces.
     * @api
     */
    public function setDescendants(array $value = []);
    /**
     * Sets nested set left value.
     *
     * NOTE: When isAutoNest() === true the descendant(s) left, right and node's right values should be updated as well.
     *
     * @param int $value Value for left.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if $value > PHP_INT_MAX - 1.
     * @api
     */
    public function setLeft($value);
    /**
     * Sets nested set level value.
     *
     * @param int $value
     *
     * NOTE: When isAutoNest() === true the descendant(s) level values should be updated as well.
     *
     * @return self Fluent interface.
     * @api
     */
    public function setLevel($value);
    /**
     * Sets nested set right value.
     *
     * @param int $value
     *
     * @return self Fluent interface.
     * @api
     */
    public function setRight($value);
    /**
     * Bulk update a node and any descendant(s) left, level, and right values.
     *
     * Mainly expected to be used when NodeInterface::isAutoNest() === false to manually update the nesting values of a
     * node and all of it's descendant(s).
     *
     * @param int $index New nested set index value used for left and right.
     * @param int $level New nested set level value.
     *
     * @return self Fluent interface.
     * @api
     */
    public function updatedNesting($index = 0, $level = 0);
}
