<?php
/**
 * Contains trait NodeTrait.
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
 * @since     0.0.1
 */
namespace NestedSet;

/**
 * Trait NodeTrait.
 *
 * Implementation example of Node Interface.
 */
trait NodeTrait
{
    /**
     * @return boolean
     * @api
     */
    public static function isAutoNest()
    {
        return self::$autoNest;
    }
    /**
     * @param boolean $value
     *
     * @api
     */
    public static function setAutoNest($value = false)
    {
        self::$autoNest = (bool)$value;
    }
    /**
     * Add a new direct descendant node to the current node.
     *
     * @param NodeInterface $node     New descendant node to be added.
     * @param string        $position Relative position in descendant list. The case insensitive string value which MUST
     *                                BE either 'first' or 'last' which causes the new descendant node to be added in
     *                                the corresponding position in the list.
     *
     * @return self Fluent interface.
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @throws \RangeException
     * @api
     */
    public function addDescendant(NodeInterface $node, $position = 'last')
    {
        $position = $this->validatePosition($position);
        if ('first' === $position) {
            array_unshift($this->descendants, $node);
        } else {
            $this->descendants[] = $node;
        }
        if (self::isAutoNest()) {
            $this->updatedNesting($this->getLeft(), $this->getLevel());
        }
        return $this;
    }
    /**
     * Use to get count of descendant nodes.
     *
     * @return int Returns number of descendant nodes.
     * @api
     */
    public function getDescendantCount()
    {
        return count($this->getDescendants());
    }
    /**
     * Used to get a list(array) of the node's descendants.
     *
     * @return NodeInterface[] Returns array of descendant node(s). Will return empty array if node has no descendants.
     * @api
     */
    public function getDescendants()
    {
        if (null === $this->descendants) {
            return [];
        }
        return $this->descendants;
    }
    /**
     * Retrieve node's nested set left value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @api
     */
    public function getLeft()
    {
        if (null === $this->left) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return $this->left;
    }
    /**
     * Retrieve node's nested set level value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @api
     */
    public function getLevel()
    {
        if (null === $this->level) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return $this->level;
    }
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @throws \RangeException Throws exception if value <= left or value > PHP_INT_MAX.
     * @api
     */
    public function getRight()
    {
        if (null === $this->right) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return $this->right;
    }
    /**
     * Check if node has any descendant(s).
     *
     * @return bool
     * @api
     */
    public function hasDescendants()
    {
        return (bool)$this->getDescendantCount();
    }
    /**
     * Remove an existing descendant node referenced by it's position.
     *
     * @param string $position Relative position in descendant list. The case insensitive string value MUST BE 'first'
     *                         or 'last' which causes the existing descendant node to be removed from the corresponding
     *                         position.
     *
     * @return NodeInterface|null Returns the removed descendant node or NULL if nothing is removed.
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @throws \RangeException
     * @api
     */
    public function removeDescendant($position = 'last')
    {
        $position = $this->validatePosition($position);
        if ('first' === $position) {
            $result = array_shift($this->descendants);
        } else {
            $result = array_pop($this->descendants);
        }
        if (self::isAutoNest()) {
            $this->updatedNesting($this->getLeft(), $this->getLevel());
        }
        return $result;
    }
    /**
     * @param NodeInterface[] $value
     *
     * @return self Fluent interface.
     * @throws \DomainException
     * @throws \LogicException
     * @throws \RangeException
     * @api
     */
    public function setDescendants(array $value = [])
    {
        $value = array_values($value);
        $this->descendants = $value;
        if (self::isAutoNest() && (bool)count($value)) {
            $this->updatedNesting($this->getLeft(), $this->getLevel());
        }
        return $this;
    }
    /**
     * Sets nested set left value.
     *
     * @param int $value Value for left.
     *
     * @return self Fluent interface.
     * @throws \RangeException
     * @throws \LogicException
     * @throws \DomainException Throws exception if $value > PHP_INT_MAX - 1.
     * @api
     */
    public function setLeft($value = 0)
    {
        $value = (int)$value;
        if (PHP_INT_MAX === $value) {
            $mess = 'Left value can not equal PHP_INT_MAX';
            throw new \DomainException($mess);
        }
        $this->left = $value;
        if (self::isAutoNest()) {
            if ($this->hasDescendants()) {
                foreach ($this->getDescendants() as $descendant) {
                    $descendant->setLeft(++$value);
                    $value = $descendant->getRight();
                }
            }
            ++$value;
            $this->setRight($value);
        }
        return $this;
    }
    /**
     * @param int $value
     *
     * @return self Fluent interface.
     * @api
     */
    public function setLevel($value = 0)
    {
        $value = (int)$value;
        $this->level = $value;
        if (self::isAutoNest() && $this->hasDescendants()) {
            ++$value;
            foreach ($this->getDescendants() as $descendant) {
                $descendant->setLevel($value);
            }
        }
        return $this;
    }
    /**
     * @param int $value
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if new value is <= current left value.
     * @throws \LogicException
     * @api
     */
    public function setRight($value = 1)
    {
        $value = (int)$value;
        if ($value <= $this->getLeft()) {
            $mess = 'Right value must be greater than left value';
            throw new \DomainException($mess);
        }
        $this->right = $value;
        return $this;
    }
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
     * @throws \RangeException
     * @throws \LogicException
     * @throws \DomainException
     * @api
     */
    public function updatedNesting($index = 0, $level = 0)
    {
        $isNested = self::isAutoNest();
        self::setAutoNest(true);
        $this->setLeft($index);
        $this->setLevel($level);
        self::setAutoNest($isNested);
        return $this;
    }
    /**
     * @param $position
     *
     * @return string
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    protected function validatePosition($position)
    {
        if (!is_string($position)) {
            $mess = sprintf('Expected position to a string but was given %1$s instead', gettype($position));
            throw new \InvalidArgumentException($mess);
        }
        $position = strtolower($position);
        if (!in_array($position, ['first', 'last'], true)) {
            $mess = sprintf('Unknown string value %1$s given for position', $position);
            throw new \DomainException($mess);
        }
        return $position;
    }
    /**
     * Determines if methods like setLeft(), setLevel() should automatically update descendants as well.
     *
     * Should be false by default to allow for lazy loading and to ensure large and multiple descendant tree additions
     * to not cause processing spikes.
     *
     *
     * @var bool $autoNest
     */
    protected static $autoNest = false;
    /**
     * List(array) of descendant nodes.
     *
     * @var NodeInterface[] $descendants
     */
    private $descendants = [];
    /**
     * @var int $left Node's nested set left value.
     */
    private $left;
    /**
     * @var int $level Node's nested set level value.
     */
    private $level;
    /**
     * @var int $right Node's nested set right value.
     */
    private $right;
}
