<?php
namespace DimasP\GenericTree;
use Exception;

// TODO: how to make this using require(). phpunit doesn't like like require().
require_once "node.php";

/**
 * N-ary tree i.e.
 * Generic Tree class
 * https://en.wikipedia.org/wiki/K-ary_tree
 *
 * @license https://opensource.org/licenses/MIT
 * @author Dimas Prameshwara
 */
class GenericTree
{

    public $root;

    function __construct ()
    {
        $this->root = new Node();
    }

    /**
     * Inserting object to tree
     *
     * @param array $indexes
     *            array() is inserting to root, array(1) inserting to
     *            root->first child
     * @param unknown $value
     *            can be anything
     */
    public function insert (Array $indexes, $value)
    {
        $newNode = new Node($value);
        $currentNode = $this->root;
        $this->_insert($currentNode, $newNode, $indexes);
    }

    private function _insert (Node $currentNode, Node $newNode, Array $indexes)
    {
        if (sizeof($indexes) > 0) {
            if ($currentNode->getSizeOfChildren() === 0) {
                throw new Exception('insert failed, $indexes level out of bounds');
            }
            $index = array_shift($indexes);
            $currentNode = $currentNode->getChild($index);
            $this->_insert($currentNode, $newNode, $indexes);
        } else {
            $currentNode->addChild($newNode);
        }
    }

    /**
     * Traverse the tree while applying function.
     * https://en.wikipedia.org/wiki/Tree_traversal#Generic_tree
     *
     * @param callable $preOp
     *            0 argument, accessing Node->value
     * @param callable $inOp
     *            1 argument, accessing Node->value
     * @param callable $postOp
     *            0 argument, accessing Node->value
     */
    public function inOrder (Callable $preOp, Callable $inOp, Callable $postOp)
    {
        $this->_inOrder($this->root, $preOp, $inOp, $postOp);
    }

    private function _inOrder (Node $n, Callable $preOp, Callable $inOp, Callable $postOp)
    {
        $preOp();
        for ($index = 0; $index < $n->getSizeOfChildren(); $index ++) {
            $nodeValue =& $n->getChild($index);
            $inOp($nodeValue->value);
            $this->_inOrder($n->getChild($index), $preOp, $inOp, $postOp);
        }
        $postOp();
    }

    /**
     * Traverse the tree while applying function.
     * https://en.wikipedia.org/wiki/Tree_traversal#Generic_tree
     *
     * @param callable $preOp
     *            1 argument, accessing Parent Node
     * @param callable $inOp
     *            1 argument, accessing Child Node
     * @param callable $postOp
     *            1 argument, accessing Parent Node
     */
    public function inOrder2 (Callable $preOp, Callable $inOp, Callable $postOp)
    {
        $this->_inOrder2($this->root, $preOp, $inOp, $postOp);
    }
    
    private function _inOrder2 (Node &$n, Callable $preOp, Callable $inOp, Callable $postOp)
    {
        $preOp($n);
        for ($index = 0; $index < $n->getSizeOfChildren(); $index ++) {
            $node =& $n->getChild($index);
            $inOp($node);
        }
        for ($index = 0; $index < $n->getSizeOfChildren(); $index ++) {
            $node =& $n->getChild($index);
            $this->_inOrder2($n->getChild($index), $preOp, $inOp, $postOp);
        }
        $postOp($n);
    }
    
    /**
     * Change a node value
     * A mask of $instance->root->getChild(lv0)->getChild(lv1)->...->value =
     * $newValue
     *
     * @param array $indexes
     *            array(0) = first element, array(0,0) first element of first
     *            child
     * @param unknown $value
     *            can be anything
     */
    public function setNodeValue (Array $indexes, $value)
    {
        $newNode = new Node($value);
        $currentNode = $this->root;
        $this->_setNode($currentNode, $newNode, $indexes);
    }

    private function _setNode (Node $currentNode, Node $newNode, Array $indexes)
    {
        if ($currentNode->getSizeOfChildren() === 0 && sizeof($indexes) > 0) {
            throw new Exception('insert failed, $indexes level out of bounds');
        }
        $index = array_shift($indexes);
        if (sizeof($indexes) > 0) {
            $currentNode = $currentNode->getChild($index);
            $this->_setNode($currentNode, $newNode, $indexes);
        } else {
            $currentNode->setChild($index, $newNode);
        }
    }

    /**
     * Get a node value
     * A mask for return $instance->root->getChild()->getChild()->...->value
     * 
     * @param array $indexes
     *            array(0) = first element, array(0,0) first element of first
     *            child
     * @param unknown $value
     *            can be anything
     */
    public function getNodeValue (Array $indexes)
    {
        $currentNode = $this->root;
        $this->_getNode($currentNode, $indexes, $temporary);
        return $temporary;
    }

    private function _getNode (Node $currentNode, Array $indexes, &$temporary)
    {
        $index = array_shift($indexes);
        if (sizeof($indexes) === 0 ){
            $temporary = $currentNode->getChild($index)->value;
        } else {
            $this->_getNode($currentNode->getChild($index),$indexes, $temporary);
        }
    }
}