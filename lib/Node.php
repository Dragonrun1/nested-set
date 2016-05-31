<?php
/**
 * Contains class Node.
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
 * Class Node
 */
class Node implements NodeInterface
{
    use NodeTrait;
    /**
     * Node constructor.
     *
     * @param int $left
     * @param int $level
     * @param int $right
     *
     * @throws \DomainException
     * @throws \LogicException
     * @throws \RangeException
     * @uses NodeInterface::setLeft()
     * @uses NodeInterface::setLevel()
     * @uses NodeInterface::setRight()
     */
    public function __construct($left = 0, $level = 0, $right = 1)
    {
        $this->setLeft($left)
             ->setLevel($level)
             ->setRight($right);
    }
}
