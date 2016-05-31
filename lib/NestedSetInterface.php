<?php
/**
 * Contains interface NestedSetInterface.
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
namespace NestedSet;

/**
 * Interface NestedSetInterface
 */
interface NestedSetInterface extends NodeInterface
{
    /**
     * Add a new descendant node to an existing node.
     *
     * @param NodeInterface $descendant New descendant node to be added.
     * @param NodeInterface $ancestor   Which node the new descendant should be added to. If value is null assumes the
     *                                  target is the root node.
     * @param string        $position   Relative position in descendant list. A case insensitive string value which
     *                                  MUST BE either 'first' or 'last' which causes the new descendant node to be
     *                                  added in the corresponding position in the list.
     *
     * @return self Fluent interface.
     */
    public function addDescendantToNode(NodeInterface $descendant, NodeInterface $ancestor = null, $position = 'last');
    public function getAncestor();
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
    public function getAncestors();
    /**
     * Check if node has any ancestor(s).
     *
     * @return bool Normally only a root node will return false.
     */
    public function hasAncestors();
}
