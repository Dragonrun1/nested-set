<?php
/**
 * Created by PhpStorm.
 * User: Dragonaire
 * Date: 6/5/2016
 * Time: 5:53 PM
 */
namespace Spec;

use NestedSet\NodeInterface;
use NestedSet\XmlNodeTrait;

/**
 * Class MockXmlNodeTrait
 */
class MockXmlNodeTrait implements NodeInterface
{
    use XmlNodeTrait;
    /**
     * @return string
     */
    public function asXml()
    {
        return (string)$this->getElement()->asXML();
    }
}
