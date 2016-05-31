<?php
/**
 * Contains trait NestedSetTrait.
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
 * Class NestedSetTrait
 */
trait NestedSetTrait
{
    use NodeTrait;
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
    public function addDescendantToNode(NodeInterface $descendant, NodeInterface $ancestor = null, $position = 'last')
    {
        if (null === $ancestor) {
            $ancestor = $this->getRoot();
        }
        $ancestor->addDescendant($descendant, $position);
    }
    /**
     * @return NodeInterface
     */
    public function getRoot()
    {
        return $this->root;
    }
    /**
     * @param NodeInterface $root
     *
     * @return self Fluent interface.
     */
    public function setRoot(NodeInterface $root)
    {
        $this->root = $root;
        return $this;
    }
    /**
     * Root node for NestedSet.
     *
     * @var NodeInterface $root
     */
    private $root;
}
