# GenericTree
N-ary tree with higher order function while traversing.

## Requirements

* PHP 5.4.0 or later

## Usage:

~~~
$tree = new GenericTree();
$tree->insert(array (), "1");
$tree->insert(array (), "2");
$tree->insert(array (), "3");
$tree->insert(array (), "4");
$tree->insert(array (3), "4,1");
$tree->insert(array (3), "4,2");
$tree->insert(array (2), "3,1");
$tree->insert(array (2, 0), "3,1,1");

$preOp = function () {
	echo "(";
};
$inOp = function ($arg) {
	echo " $arg ";
};
$postOp = function () {
	echo ")";
};

$tree->inOrder($preOp, $inOp, $postOp);
// prints ( 1 () 2 () 3 ( 3,1 ( 3,1,1 ())) 4 ( 4,1 () 4,2 ()))
~~~
