<?php
namespace DimasP\GenericTree;

class GenericTreeTest extends \PHPUnit_Framework_TestCase
{

    public function test_constructor ()
    {
        $gt = new GenericTree();
        $this->assertEmpty($gt->root->value);
        $this->assertEquals($gt->root->getSizeOfChildren(), 0);
    }

    public function treeProvider ()
    {
        $tree = new GenericTree();
        $tree->insert(array(), "1");
        $tree->insert(array(), "2");
        $tree->insert(array(), "3");
        $tree->insert(array(), "4");
        $tree->insert(array(3), "4,1");
        $tree->insert(array(3), "4,2");
        $tree->insert(array(2), "3,1");
        $tree->insert(array(2,0), "3,1,1");
        return $tree;
    }

    public function test_insert ()
    {
        $tr = $this->treeProvider();
        $this->assertEquals("1", $tr->root->getChild(0)->value);
        $this->assertEquals("4", $tr->root->getChild(3)->value);
        $this->assertEquals(4, $tr->root->getChild(3)->value);
        $this->assertEquals("3,1", $tr->root->getChild(2)
            ->getChild(0)->value);
        $this->assertEquals("3,1,1", $tr->root->getChild(2)
            ->getChild(0)
            ->getChild(0)->value);
    }

    public function test_inOrder ()
    {
        $tr = $this->treeProvider();
        $preOp = function  ()
        {
            echo "(";
        };
        $inOp = function  ($arg)
        {
            echo " $arg ";
        };
        $postOp = function  ()
        {
            echo ")";
        };
        $expected_output = "( 1 () 2 () 3 ( 3,1 ( 3,1,1 ())) 4 ( 4,1 () 4,2 ()))";
        $this->expectOutputString($expected_output);
        $tr->inOrder($preOp, $inOp, $postOp);
    }

    public function test_getChild ()
    {
        $n = $this->treeProvider();
        $this->assertNotEmpty($n->root->getChild(0));
        $this->assertNotEmpty($n->root->getChild(1));
        $this->assertNotEmpty($n->root->getChild(2));
        $this->assertNotEmpty($n->root->getChild(2)
            ->getChild(0));
        $this->assertEquals($n->root->getChild(2)
            ->getChild(0)->value, "3,1");
        $this->assertNotEquals($n->root->getChild(2)
            ->getChild(0)->value, 3.1);
    }

    /**
     * @expectedException Exception
     */
    public function test_exceptionInsert ()
    {
        $tree = new GenericTree();
        $tree->insert(array(1), "exc");
    }

    /**
     * @expectedException Exception
     */
    public function test_exceptionInOrder ()
    {
        $tree = new GenericTree();
        $tree->insert(array(1), "exc");
    }

    public function test_setTree ()
    {
        $n = $this->treeProvider();
        $n->setNodeValue(array(2,0), "changed");
        $this->assertEquals("changed", $n->root->getChild(2)
            ->getChild(0)->value);
    }

    public function test_getTree ()
    {
        $n = $this->treeProvider();
        $n->setNodeValue(array(2,0), "changed");
        $this->assertEquals("1", $n->getNodeValue(array(0)));
        $this->assertEquals("2", $n->getNodeValue(array(1)));
        $this->assertEquals("changed", $n->getNodeValue(array(2,0)));
    }

    public function test_inOrderWithReference ()
    {
        $tr = $this->treeProvider();
        $glob = "";
        $inOp = function  ($children, $depth) use ( &$glob)
        {
            $val = $children->value;
            if ($children->getSizeOfChildren() === 0) {
                $glob .= "<option>$val</option>";
            }
        };
        $preOp = function  ($children, $depth) use ( &$glob)
        {
            $val = $children->value;
            if ($children->getSizeOfChildren() > 0) {
                $glob .= "<optgroup label='$val'>";
            }
        };
        $postOp = function  ($children, $depth) use ( &$glob)
        {
            $val = $children->value;
            if ($children->getSizeOfChildren() > 0) {
                $glob .= "</optgroup>";
            }
        };
        $expectedOutput = <<<EOD
<optgroup label=''><option>1</option><option>2</option><optgroup label='3'><optgroup label='3,1'><option>3,1,1</option></optgroup></optgroup><optgroup label='4'><option>4,1</option><option>4,2</option></optgroup></optgroup>
EOD;
        
        preg_replace("/\r|\n/", "", trim($glob));
        $tr->inOrder2($preOp, $inOp, $postOp);
        $this->assertContains($glob, $expectedOutput);
    }
}
?>
