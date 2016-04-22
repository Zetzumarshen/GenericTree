# GenericTree
N-ary tree with higher order function while traversing.

## Requirements

* PHP 5.4.0 or later

## Usage:

~~~
use DimasP\GenericTree as Tree;

require_once 'GenericTree.php';

$tree = new Tree\GenericTree();

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

Or alternatively you can remove this line in `GenericTree.php` and `Node.php`:
 
~~~
namespace DimasP\GenericTree;
~~~

and remove this line in `Node.php`:

~~~
use Exception;
~~~

And load the library using `require_once`.
