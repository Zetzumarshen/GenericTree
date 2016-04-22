<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart

/**
 * autoload relevant classes. also complies with phpunit 5.3.2
 */ 
spl_autoload_register(function ($className) {
	$namespace = 'DimasP\\GenericTree';
    if (strpos($className, $namespace) === 0) {
        $className = str_replace($namespace, '', $className);
        $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require_once($fileName);
        }
    }
});

// @codeCoverageIgnoreEnd