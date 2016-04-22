<?php

namespace DimasP\GenericTree;

use Exception;

// TODO: how to make this using require(). phpunit doesn't like like require().
require_once "node.php"; 

class GenericTree {

	public $root;

	function __construct() {
		$this->root = new Node();
	}

	/**
	 * Inserting object to tree
	 * 
	 * @param array $indexes array() is inserting to root, array(1) inserting to root->first child 
	 * @param unknown $value can be anything
	 */
	public function insert(Array $indexes, $value) {
		$newNode = new Node($value);
		$currentNode = $this->root;
		$this->_insert($currentNode, $newNode, $indexes);
	}

	private function _insert(Node $currentNode, Node $newNode, Array $indexes) {
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
	 * @param callable $preOp 0 argument
	 * @param callable $inOp 1 argument
	 * @param callable $postOp 0 argumen
	 */
	public function inOrder(Callable $preOp, Callable $inOp, Callable $postOp) {
		$this->_inOrder($this->root, $preOp, $inOp, $postOp);
	}

	private function _inOrder(Node $n, Callable $preOp, Callable $inOp, Callable $postOp) {
		$preOp();
		for($index = 0; $index < $n->getSizeOfChildren(); $index ++) {
			$nodeValue = $n->getChild($index)->value;
			$inOp($nodeValue);
			$this->_inOrder($n->getChild($index), $preOp, $inOp, $postOp);
		}
		$postOp();
	}
}