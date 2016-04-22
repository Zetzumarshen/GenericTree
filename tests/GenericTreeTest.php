<?php
namespace DimasP\GenericTree;

class GenericTreeTest extends \PHPUnit_Framework_TestCase {
	
	public function test_constructor(){
		$gt = new GenericTree();
		$this->assertEmpty($gt->root->value);
		$this->assertEquals($gt->root->getSizeOfChildren(),0);
	}
	
	public function test_insert() {
		//$tree = new GenericTree();
		//$tree->insert(array (), "1");
		$this->markTestIncomplete();
	}

	public function tree_provider(){
		/*
		$tree = new GenericTree();
		$tree->insert(array (), "1");
		$tree->insert(array (), "2");
		$tree->insert(array (), "3");
		$tree->insert(array (), "4");
		$tree->insert(array (3), "4,1");
		$tree->insert(array (3), "4,2");
		$tree->insert(array (2), "3,1");
		$tree->insert(array (2, 0), "3,1,1");
		return $tree;*/
	}
	
	public function test_inOrder() {
		/*
		$preOp = function () {
			echo "( ";
		};
		$inOp = function ($arg) {
			echo " $arg ";
		};
		$postOp = function () {
			echo " )";
		};
		$expected_output = "( 1 ( ) 2 ( ) 3 ( 3,1 ( 3,1,1 ( ) ) ) 4 ( 4,1 ( ) 4,2 ( ) ) )";
		$this->assertEquals($expected_output, $tree($preOp, $inOp, $postOp));
		*/
		$this->markTestIncomplete();
	}
}

