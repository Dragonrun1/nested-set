<?php
/**
 *  LICENSE:
 *  This file is part of the Nested-Set library.
 *  Copyright (C) 2016 Michael Cummings
 *
 *  This program is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU Lesser General Public License as published by the
 *  Free Software Foundation, either version 3 of the License, or (at your
 *  option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT
 *  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 *  FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 *  for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program. If not, see
 *  <http://www.gnu.org/licenses/>.
 *
 *  You should be able to find a copy of this license in the LICENSE.md file. A
 *  copy of the GNU GPL should also be available in the GNU-GPL.md file.
 *
 * @copyright 2016 Michael Cummings
 * @license   LGPL-3.0+
 * @author    Michael Cummings <mgcummings@yahoo.com>
 *
 */
/**
 * Created by PhpStorm.
 * User: Dragonaire
 * Date: 5/31/2016
 * Time: 4:24 PM
 */
namespace Spec\NestedSet;

use PhpSpec\ObjectBehavior;

/**
 * Class SpecNodeTrait
 *
 * @mixin \NestedSet\Node
 *
 * @method void shouldImplement()
 * @method void shouldReturn($value)
 * @method $this duringSetLeft($value)
 */
class NodeTraitSpec extends ObjectBehavior
{
    public function ItReturnsEmptyArrayBeforeDescendantsAreSet()
    {
        $this->getDescendants()
             ->shouldHaveCount(0);
    }
    public function ItThrowsExceptionForValueEqualsPHP_INT_MAXWhenTryingToSetLeft()
    {
        $mess = 'Left value can not equal PHP_INT_MAX';
        $this->shouldThrow(new \DomainException($mess))
             ->duringSetLeft(PHP_INT_MAX);
    }
    public function itProvidesFluentInterfaceFromAllSetters()
    {
        $this->setDescendants()
             ->shouldReturn($this);
        $this->setLeft()
             ->shouldReturn($this);
        $this->setLevel()
             ->shouldReturn($this);
        $this->setRight()
             ->shouldReturn($this);
    }
    public function let()
    {
        $this->beAnInstanceOf('\\Spec\\NestedSet\\MockNodeTrait');
    }
}
