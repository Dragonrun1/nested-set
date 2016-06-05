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
use Prophecy\Argument;

/**
 * Class SpecNodeTrait
 *
 * @mixin \NestedSet\Node
 *
 *** PhpSpec general methods
 * @method void shouldImplement($value)
 * @method void shouldReturn($value)
 *** PhpSpec per spec methods
 * @method void duringGetLeft()
 * @method void duringGetLevel()
 * @method void duringGetRight()
 * @method $this duringSetLeft($value)
 * @method $this duringSetRight($value)
 */
class NodeTraitSpec extends ObjectBehavior
{
    /**
     *
     */
    public function itIsInitializable()
    {
        $this->shouldImplement('NestedSet\NodeInterface');
    }
    /**
     *
     */
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
    /**
     *
     */
    public function itReturnsEmptyArrayBeforeAnyDescendantsAreAdded()
    {
        $this->getDescendants()
             ->shouldHaveCount(0);
    }
    /**
     * @param \Spec\MockNode $descendant
     */
    public function itShouldDuringAddDescendantChangeLeftOfDescendantWhenIsAutoNestIsTrue($descendant)
    {
        $this->setLeft(2)
             ->setLevel()
             ->setRight(3);
        $descendant->getRight()
                   ->willReturn(4);
        $descendant->setLeft(3)
                   ->shouldBeCalled();
        $descendant->setLevel(1)
                   ->shouldBeCalled();
        $descendant->getRight()
                   ->shouldBeCalledTimes(1);
        self::setAutoNest(true);
        $this->addDescendant($descendant);
        self::setAutoNest(false);
    }
    /**
     * @param \Spec\MockNode $descendant
     */
    public function itShouldDuringAddDescendantChangeLevelOfDescendantWhenIsAutoNestIsTrue($descendant)
    {
        $this->setLeft(2)
             ->setLevel(2)
             ->setRight(3);
        $descendant->getRight()
                   ->willReturn(4);
        $descendant->setLeft(3)
                   ->shouldBeCalled();
        $descendant->setLevel(3)
                   ->shouldBeCalled();
        $descendant->getRight()
                   ->shouldBeCalledTimes(1);
        self::setAutoNest(true);
        $this->addDescendant($descendant);
        self::setAutoNest(false);
    }
    /**
     * @param \Spec\MockNode $descendant
     */
    public function itShouldDuringAddDescendantNotChangeLeftOfDescendantWhenIsAutoNestIsFalse($descendant)
    {
        self::setAutoNest(false);
        $descendant->getRight()
                   ->shouldNotBeCalled();
        $descendant->setLeft()
                   ->shouldNotBeCalled();
        $this->addDescendant($descendant)
             ->setLeft(1);
        $mess = 'Tried to use property before value was set';
        $this->shouldThrow(new \LogicException($mess))
             ->duringGetRight();
    }
    /**
     * @param \Spec\MockNode $descendant1
     * @param \Spec\MockNode $descendant2
     * @param \Spec\MockNode $descendant3
     */
    public function itShouldDuringAddDescendantPutThemInOrderByPositionAndNotAddedOrder(
        $descendant1,
        $descendant2,
        $descendant3
    ) {
        self::setAutoNest(false);
        $this->addDescendant($descendant1);
        $this->addDescendant($descendant3, 'first');
        $this->getDescendants()
             ->shouldReturn([$descendant3, $descendant1]);
        $this->addDescendant($descendant2, 'last');
        $this->getDescendants()
             ->shouldReturn([$descendant3, $descendant1, $descendant2]);
    }
    /**
     * @param \Spec\MockNode $descendant1
     * @param \Spec\MockNode $descendant2
     * @param \Spec\MockNode $descendant3
     */
    public function itShouldDuringRemoveDescendantRemoveThemFromCorrectEnd($descendant1, $descendant2, $descendant3)
    {
        self::setAutoNest(false);
        $this->addDescendant($descendant1);
        $this->addDescendant($descendant3, 'first');
        $this->addDescendant($descendant2, 'last');
        $this->getDescendants()
             ->shouldReturn([$descendant3, $descendant1, $descendant2]);
        $this->removeDescendant('first');
        $this->getDescendants()
             ->shouldReturn([$descendant1, $descendant2]);
        $this->removeDescendant('last');
        $this->getDescendants()
             ->shouldReturn([$descendant1]);
    }
    /**
     * @param \Spec\MockNode $descendant1
     * @param \Spec\MockNode $descendant2
     */
    public function itShouldDuringSetLeftChangeLeftOfDescendantsWhenIsAutoNestIsTrue($descendant1, $descendant2)
    {
        $descendant1->setLeft(3)
                    ->shouldBeCalled();
        $descendant1->getRight()
                    ->willReturn(4);
        $descendant1->getRight()
                    ->shouldBeCalledTimes(1);
        $descendant2->setLeft(5)
                    ->shouldBeCalled();
        $descendant2->getRight()
                    ->willReturn(6);
        $descendant2->getRight()
                    ->shouldBeCalledTimes(1);
        $this->setDescendants([$descendant1, $descendant2]);
        self::setAutoNest(true);
        $this->setLeft(2);
        self::setAutoNest(false);
    }
    /**
     * @param \Spec\MockNode $descendant1
     * @param \Spec\MockNode $descendant2
     */
    public function itShouldDuringSetLeftNotChangeLeftOfDescendantsWhenIsAutoNestIsFalse($descendant1, $descendant2)
    {
        self::setAutoNest(false);
        $descendant1->setLeft()
                    ->shouldNotBeCalled();
        $descendant1->getRight()
                    ->shouldNotBeCalled();
        $descendant2->setLeft()
                    ->shouldNotBeCalled();
        $descendant2->getRight()
                    ->shouldNotBeCalled();
        $this->setDescendants([$descendant1, $descendant2]);
        $this->setLeft(2);
    }
    /**
     * @param \Spec\MockNode $descendant
     */
    public function itShouldHaveADescendantAfterAddingOne($descendant)
    {
        $this->addDescendant($descendant)
             ->getDescendants()
             ->shouldHaveCount(1);
    }
    /**
     * @param \NestedSet\Node $descendant
     */
    public function itShouldHaveNoDescendantsAfterRemovingLastOne($descendant)
    {
        $this->addDescendant($descendant)
             ->getDescendants()
             ->shouldHaveCount(1);
        $this->removeDescendant();
        $this->getDescendants()
             ->shouldHaveCount(0);
    }
    /**
     *
     */
    public function itThrowsExceptionForRightValueLessThanOrEqualLeftValueDuringSetRight()
    {
        $mess = 'Right value must be greater than left value';
        $this->setLeft(2);
        $this->shouldThrow(new \DomainException($mess))
             ->duringSetRight(1);
    }
    /**
     *
     */
    public function itThrowsExceptionForToLargeOfValueWhenTryingToSetLeft()
    {
        $mess = 'Left value can not equal PHP_INT_MAX';
        $this->shouldThrow(new \DomainException($mess))
             ->duringSetLeft(PHP_INT_MAX);
    }
    /**
     *
     */
    public function itThrowsExceptionForUsingGettersBeforeSetters()
    {
        $mess = 'Tried to use property before value was set';
        $this->shouldThrow(new \LogicException($mess))
             ->duringGetLeft();
        $this->shouldThrow(new \LogicException($mess))
             ->duringGetLeft();
        $this->shouldThrow(new \LogicException($mess))
             ->duringGetRight();
    }
    /**
     *
     */
    public function let()
    {
        $this->beAnInstanceOf('\\Spec\\MockNodeTrait');
    }
}
