<?php

if (!class_exists('\Symfony\Component\Console\Application')) {
    if (file_exists($file = __DIR__.'/../../../../vendor/autoload.php') || file_exists($file = __DIR__.'/../autoload.php')) {
        require_once $file;
    } elseif (file_exists($file = __DIR__.'/../autoload.php.dist')) {
        require_once $file;
    }
}

$finder = new \Symfony\Component\Finder\Finder();
$finder->files()->name('*.php')->in(__DIR__.'/../Propel/Generator/Command');

$app = new \Symfony\Component\Console\Application('Propel', \Propel\Runtime\Propel::VERSION);

foreach ($finder as $file) {
    $ns = '\\Propel\\Generator\\Command';
    $r  = new \ReflectionClass($ns.'\\'.$file->getBasename('.php'));
    if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
        $app->add($r->newInstance());
    }
}

$app->run();
