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

	public function inOrder(Callable $preOp, Callable $inOp, Callable $postOp) {
		$this->_inOrder($this->root, $preOp, $inOp, $postOp);
	}

	private function _inOrder(Node $n, Callable $preOp, Callable $inOp, Callable $postOp) {
		try {
			$preOp();
			for($index = 0; $index < $n->getSizeOfChildren(); $index ++) {
				$nodeValue = $n->getChild($index)->value;
				$inOp($nodeValue);
				$this->_inOrder($n->getChild($index), $preOp, $inOp, $postOp);
			}
			$postOp();
		} catch ( Exception $e ) {
			$msg = $e->message();
			throw new Exception("inOrder failed \n $msg");
		}
	}
}

/*
class GenericTreeTest {

	public function StartTest() {
		try {
			echo "Starting Test. <br>";
			$preOp = function () {
				echo "( ";
			};
			$inOp = function ($arg) {
				echo " $arg ";
			};
			$postOp = function () {
				echo " )";
			};
			$tree = new GenericTree();
			$tree->insert(array (), "1");
			$tree->insert(array (), "2");
			$tree->insert(array (), "3");
			$tree->insert(array (), "4");
			$tree->insert(array (3), "4,1");
			$tree->insert(array (3), "4,2");
			$tree->insert(array (2), "3,1");
			$tree->insert(array (2, 0), "3,1,1");
			echo $tree->inOrder($preOp, $inOp, $postOp);
			echo "<br> Ending Test.";
			echo "<br>". __NAMESPACE__;
		} catch ( Exception $e ) {
			
		}
	}
}

$gt = new GenericTreeTest();
$gt->startTest();*/