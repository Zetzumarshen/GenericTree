<?php

namespace DimasP\GenericTree;

use Exception;

/**
 * Node that is used for GenericTree
 * 
 * @license https://opensource.org/licenses/MIT
 * @author Dimas Prameshwara
 */
class Node {

	private $children = array ();

	public $value = NULL;

	public function __construct($value = NULL) {
		$this->value = $value;
	}

	/**
	 * alias of sizeof($this->children)
	 * 0 means an empty children
	 * 
	 * @return integer children size
	 */
	public function getSizeOfChildren() {
		return sizeof($this->children);
	}

	/**
	 * get child(array) at index
	 * 
	 * @param integer $index
	 * @throws Exception
	 * @return Node $child
	 */
	public function getChild($index) {
		if ($index < sizeof($this->children)) {
			return $this->children [$index];
		} else {
			throw new Exception('getChild failed, $index out of Bounds');
		}
	}

	/**
	 * set child(array) at index to a value.
	 * children[$index] = $newNode
	 * 
	 * @param integer $index
	 * @param Node $newNode
	 * @throws Exception
	 */
	public function setChild($index, Node $newNode) {
		if ($index < sizeof($this->children)) {
			$this->children [$index] = $newNode;
		} else {
			throw new Exception('setChild failed, $index out of Bounds');
		}
	}
	
	/**
	 * add child to parent node
	 * 
	 * @param Node $newNode 
	 */
	public function addChild(Node $newNode) {
		$this->children [] = $newNode;
	}
}
