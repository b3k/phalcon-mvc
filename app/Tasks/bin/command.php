<?php

if (!class_exists('\Symfony\Component\Console\Application')) {
    if (file_exists($file = __DIR__ . '/../../../vendor/autoload.php') || file_exists($file = __DIR__ . '/../autoload.php')) {
        require_once $file;
    } elseif (file_exists($file = __DIR__ . '/../autoload.php.dist')) {
        require_once $file;
    }
}

$finder = new \Symfony\Component\Finder\Finder();
$finder->files()->name('*Command.php')->path('Command/')->in(__DIR__ . '/../../');

$app = new \Symfony\Component\Console\Application('Falconidae', '1.0');

foreach ($finder as $file) {

    $class = '\\App\\' . strtr($file->getRelativePath() . '\\' . $file->getBasename('.php'), '/', '\\');

    $r = new \ReflectionClass($class);
    if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
        $app->add($r->newInstance());
    }
}

$app->run();
