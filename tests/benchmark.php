<?php

include __DIR__ . '/../vendor/autoload.php';

$i = 0;
$max = 500000;
$storage = array();

$time_start = microtime(true);

while ($i < $max) {
    $flake = \Simpleflake\generate();
    if (array_key_exists('x'.$flake, $storage)) {
        echo "Collision on ".$flake . " ($i of $max)".PHP_EOL;
        $time = microtime(true) - $time_start;
        echo "Runtime: $time seconds" . PHP_EOL;
        echo "Req/sec: " . ($i / $time) . PHP_EOL;
        exit(1);
    }
    $storage['x'.$flake] = null;

    echo $flake . PHP_EOL;
    $i++;
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Runtime: $time seconds" . PHP_EOL;
echo "Req/sec: " . ($i / $time) . PHP_EOL;
