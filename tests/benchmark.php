<?php

include __DIR__ . '/../vendor/autoload.php';

// Record the number of collisions.
$collisions = [];
$storage = [];

// Record the number of decrements.
// Since this algorithm has a component comprised of random bits, high-velocity sequences can actually
// decrease. This is generally considered an acceptable trade-off for uncoordinated vs coordinated ID
// generation. In practice, this is rarely an issue unless very precise ordering is key to the
// performance of the system implementing Simpleflake.
$decrements = [];

// Delay between generation requests (in microseconds).
$delay = 0;
if (!empty($argv[1]) && is_int((int) $argv[1]) && ($argv[1] > 0)) {
    $delay = (int) $argv[1];
}

$i            = 0;
$max          = 500000;
$largestFlake = null;
$time_start   = microtime(true);

while ($i < $max) {
    $flake = \Simpleflake\generate();
    if (empty($largestFlake)) {
        $largestFlake = $flake;
    } elseif ($flake < $largestFlake) {
        $decrements[] = $flake . " ($i of $max)";
    }
    if (array_key_exists('x'.$flake, $storage)) {
        $collisions[] = $flake . " ($i of $max)";
    }
    $storage['x'.$flake] = null;
    if (!empty($argv[2]) && ($argv[2] == '--verbose')) {
        echo $flake . PHP_EOL;
    }
    if ($delay > 0) {
        usleep($delay);
    }
    $i++;
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Runtime:    $time seconds" . PHP_EOL;
echo "Requests:   " . $i . PHP_EOL;
echo "Req/sec:    " . ($i / $time) . PHP_EOL;
echo "Delay/req:  " . $delay . " microseconds" . PHP_EOL;
echo "Collisions: " . count($collisions) . PHP_EOL;
echo "Decrements: " . count($decrements) . PHP_EOL;
