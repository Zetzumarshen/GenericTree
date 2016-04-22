<?php 

namespace DimasP\GenericTree;

class NodeTest extends \PHPUnit_Framework_TestCase {

	public function test_construct(){
		$node = new Node();
		$this->assertEquals($node->value,NULL);
		
		$node = new Node("Random String");
		$this->assertEquals($node->value,"Random String");
	}
	
	function addChildren(){
		$node = new Node();
		$node1 = new Node("node1");
		$node2 = new Node("node2");
		$node->addChild($node1);
		$node->addChild($node1);
		
		$node2->addChild($node2);
		$node->addChild($node2);
		return $node;
	}
	
	public function test_getChild() {
		$n = $this->addChildren();
		$this->assertNotEmpty($n->getChild(0));
		$this->assertNotEmpty($n->getChild(1));
		$this->assertNotEmpty($n->getChild(2));
		$this->assertNotEmpty($n->getChild(2)->getChild(0));
		$this->assertEquals($n->getChild(2)->getChild(0)->value,"node2");
	}
	
	/**
	 * @expectedException Exception
	 */
	public function test_exceptionGetChild(){
		$n = $this->addChildren();
		$n->getChild(3);
		$n->getChild(2)->getChild(1);
	}
	
	/**
	 * @expectedException Exception
	 */
	public function test_exceptionSetChild(){
		$n = $this->addChildren();
		$newNode = new Node("newNode");
		$n->setChild(4, $newNode);
	}
	
	public function test_setChild() {
		$n = $this->addChildren();
		$newNode = new Node("newNode");
		$n->setChild(1, $newNode);
		$this->assertEquals($n->getChild(1)->value, "newNode");
	}
	
	public function test_getChildrenSize(){
		$n = $this->addChildren();
		$this->assertEquals($n->getSizeOfChildren(),3);
		$this->assertEquals($n->getChild(2)->getSizeOfChildren(),1);
	}
}