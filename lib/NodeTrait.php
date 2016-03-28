<?php
/**
 * Created by PhpStorm.
 * User: mgcum
 * Date: 3/27/2016
 * Time: 10:26 AM
 */
namespace NestSet;

/**
 * Trait NodeTrait.
 *
 * Implementation example of Node Interface.
 */
trait NodeTrait
{
    /**
     * Add a new direct descendant node to the current node.
     *
     * NOTE: If integer $value >= descendant count then it will act like 'last' would.
     *
     * @param NodeInterface $node  New descendant node to be added.
     * @param int|string    $value Relative position in descendant list with negative integers counting from last
     *                             position. Integer value MUST BE between PHP_INT_MIN and PHP_INT_MAX. The case
     *                             insensitive string value MUST BE 'first' or 'last' which causes the new descendant
     *                             node to take over the corresponding position.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if case insensitive string $value is not equal to 'last' or 'first'.
     * @throws \InvalidArgumentException Throws exception if $value is not a string or integer.
     */
    public function addDescendantByPosition(NodeInterface $node, $value = 'last')
    {
        if (is_string($value)) {
            $value = strtolower($value);
            if (!in_array($value, ['first', 'last'], true)) {
                $mess = sprintf('Unknown string value %1$s given for position', $value);
                throw new \DomainException($mess);
            }
            if ('last' === $value) {
                $value = PHP_INT_MAX;
            } elseif ('first' === $value) {
                $value = 0;
            }
        }
        if (!is_int($value)) {
            $mess = sprintf('Expected string or int but was given %1$s', gettype($value));
            throw new \InvalidArgumentException($mess);
        }
        $cnt = $this->getDescendantCount();
        if (0 === $cnt) {
            $this->descendants = [$node];
            return $this;
        }
        if (abs($value) > $cnt) {
            // preserves sign of value while keeping it in range of length.
            $value = min(1, max(-1, $value)) * $cnt;
        }
        // Insert
        array_splice($this->descendants, $value, 0, [$node]);
        // Re-index.
        $this->descendants = array_values($this->descendants);
        return $this;
    }
    /**
     * Used to get a list(array) of the node's ancestors.
     *
     * NOTE: This method will only return the immediate ancestor of the node by default. To get any additional levels of
     * the ancestors $levelsAbove value > maximum levels above but not more then PHP_INT_MAX should be used.
     *
     * @param int    $levelsAbove Determines how many ancestor level(s) above should be included relative to the node.
     * @param string $sort        Determines sorting of the ancestor list. Value is case insensitive.
     *                            'asc' (ascending): From root node to immediate ancestor.
     *                            'desc' (descending): From immediate ancestor to root node.
     *
     * @return NodeInterface[] Returns array of ancestor node(s). Root node will return empty array.
     */
    abstract public function getAncestorList($levelsAbove = 1, $sort = 'asc');
    /**
     * Use to get count of descendant nodes.
     *
     * NOTE: This method will only return a count of the direct descendants from the node by default and NOT any
     * additional levels of descendants. If you need all the descendants of a node whether or not they have intervening
     * ancestors you MUST set $levelsBelow > maximum levels below but not more than PHP_INT_MAX.
     *
     * @param int $levelsBelow
     *
     * @return int Returns number of descendant nodes.
     */
    public function getDescendantCount($levelsBelow = 1)
    {
        return count($this->getDescendantList($levelsBelow));
    }
    /**
     * Used to get a list(array) of the node's descendants.
     *
     * NOTE: This method will only return a list of the direct descendants from the node by default and NOT any
     * additional levels of descendants. If you need all the descendants of a node whether or not they have intervening
     * ancestors you MUST set $levelsBelow > maximum levels below but not more then PHP_INT_MAX should be used.
     *
     * @param int    $levelsBelow Determines how many levels of descendants relative to the node should be included.
     * @param string $sort        Determines sorting of the descendant list. Value is case insensitive.
     *                            'asc' (ascending): From first to last descendant.
     *                            'desc' (descending): From last to first descendant.
     *
     * @return NodeInterface[] Returns array of descendant node(s). Will return empty array if node has no descendants.
     */
    abstract public function getDescendantList($levelsBelow = 1, $sort = 'asc');
    /**
     * Retrieve node's nested set left value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @throws \RangeException Throws exception if value not between PHP_INT_MIN and PHP_INT_MAX - 1 inclusively,
     * or value >= right value.
     */
    public function getLeft()
    {
        if (null === $this->left) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        if ($this->left < ~PHP_INT_MAX || $this->left > (PHP_INT_MAX - 1)) {
            $mess = sprintf('Node left value of %1$s is not between PHP_INT_MIN and PHP_INT_MAX - 1 inclusively',
                $this->left);
            throw new \RangeException($mess);
        }
        if ($this->left >= $this->getRight()) {
            $mess = 'Left can NOT be >= right value';
            throw new \RangeException($mess);
        }
        return $this->left;
    }
    /**
     * Retrieve node's nested set level value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @throws \RangeException Throws exception if value not between PHP_INT_MIN and PHP_INT_MAX inclusively.
     */
    public function getLevel()
    {
        if (null === $this->level) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        if ($this->level < ~PHP_INT_MAX || $this->level > PHP_INT_MAX) {
            $mess = sprintf('Node level value of %1$s is not between PHP_INT_MIN and PHP_INT_MAX inclusively',
                $this->level);
            throw new \RangeException($mess);
        }
        return $this->level;
    }
    /**
     * Retrieve node's nested set right value.
     *
     * @return int
     * @throws \LogicException Throws exception if property accessed before value is set.
     * @throws \RangeException Throws exception if value <= left or value > PHP_INT_MAX.
     */
    public function getRight()
    {
        if (null === $this->right) {
            $mess = 'Tried to use property before value was set';
            throw new \LogicException($mess);
        }
        if ($this->right <= $this->getLeft()) {
            $mess = 'Right value can not be less than or equal to left value';
            throw new \RangeException($mess);
        }
        if ($this->right > PHP_INT_MAX) {
            $mess = 'Right value excesses PHP_INT_MAX';
            throw new \RangeException($mess);
        }
    }
    /**
     * Check if node has any ancestor(s).
     *
     * @return bool Normally only a root node will return false.
     */
    public function hasAncestors()
    {
        return (bool)$this->getAncestorList();
    }
    /**
     * Check if node has any descendant(s).
     *
     * @return bool
     * @throws \LogicException Throws exception if left or right properties are accessed before values are set.
     * @throws \RangeException Throws exception if node's left or right values are out of range.
     */
    public function hasDescendants()
    {
        return ($this->getRight() - $this->getLeft()) > 1;
    }
    /**
     * Sets nested set left value.
     *
     * @param int $value Value for left.
     *
     * @return self Fluent interface.
     * @throws \DomainException Throws exception if $value > PHP_INT_MAX - 1.
     */
    protected function setLeft($value) {
        $value = (int)$value;
        if (PHP_INT_MAX === $value) {
            $mess = 'Left value can not equal PHP_INT_MAX';
            throw new \DomainException($mess);
        }
        $this->left = (int)$value;
        return $this;
    }
    /**
     * List(array) of descendant nodes.
     *
     * @type NodeInterface[] $descendants
     */
    private $descendants = [];
    /**
     * @type int $left Node's nested set left value.
     */
    protected $left;
    /**
     * @type int $level Node's nested set level value.
     */
    protected $level;
    /**
     * @type int $right Node's nested set right value.
     */
    protected $right;
}
