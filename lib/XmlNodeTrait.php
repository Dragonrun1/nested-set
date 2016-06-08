<?php
/**
 * Contains trait XmlNodeTrait.
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
 * @since     0.0.3
 */
namespace NestedSet;

use SimpleXMLElement;

/**
 * Trait XmlNodeTrait.
 */
trait XmlNodeTrait
{
    use NodeTrait;
    /**
     * Retrieve node's nested set left value.
     *
     * @return int
     * @throws \LogicException
     * @api
     */
    public function getLeft()
    {
        if (!isset($this->getElement()['left'])) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return (int)$this->getElement()['left'];
    }
    /**
     * Retrieve node's nested set level value.
     *
     * @return int
     * @throws \LogicException
     * @api
     */
    public function getLevel()
    {
        if (!isset($this->getElement()['level'])) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return (int)$this->getElement()['level'];
    }
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     * @throws \LogicException
     * @api
     */
    public function getRight()
    {
        if (!isset($this->getElement()['right'])) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return (int)$this->getElement()['right'];
    }
    /**
     * @param SimpleXMLElement|null $value
     *
     * @return $this Fluent interface
     */
    public function setElement(SimpleXMLElement $value = null)
    {
        if (null === $value) {
            $value = new SimpleXMLElement('<root/>');
        }
        $this->element = $value;
        return $this;
    }
    /**
     * Sets nested set left value.
     *
     * NOTE: When isAutoNest() === true the descendant(s) left, right and node's right values should be updated as well.
     *
     * @param int $value Value for left.
     *
     * @return self Fluent interface.
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
        $this->getElement()['left'] = $value;
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
     * Sets nested set level value.
     *
     * @param int $value
     *
     * NOTE: When isAutoNest() === true the descendant(s) level values should be updated as well.
     *
     * @return self Fluent interface.
     * @throws \LogicException
     * @api
     */
    public function setLevel($value = 0)
    {
        $value = (int)$value;
        $this->getElement()['level'] = $value;
        if (self::isAutoNest() && $this->hasDescendants()) {
            ++$value;
            foreach ($this->getDescendants() as $descendant) {
                $descendant->setLevel($value);
            }
        }
        return $this;
    }
    /**
     * Sets nested set right value.
     *
     * @param int $value
     *
     * @return self Fluent interface.
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
        $this->getElement()['right'] = $value;
        return $this;
    }
    /**
     * @return SimpleXMLElement
     * @throws \LogicException
     */
    public function getElement()
    {
        if (null === $this->element) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        return $this->element;
    }
    /**
     * @var SimpleXMLElement $element
     */
    private $element;
}
