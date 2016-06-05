<?php

namespace Spec\NestedSet;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NodeSpec
 */
class NodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NestedSet\Node');
    }
}
