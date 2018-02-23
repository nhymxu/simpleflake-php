# simpleflake-php


Distributed ID generation in PHP for the lazy. Based on the [python implementation](https://github.com/SawdustSoftware/simpleflake) from [SawdustSoftware](https://github.com/SawdustSoftware).

Since this algorithm has a component comprised of random bits, high-velocity sequences can actually decrease. This is generally considered an acceptable trade-off for uncoordinated vs coordinated ID generation. In practice, this is rarely an issue unless very precise ordering is key to the performance of the system implementing Simpleflake.


# Configure

##### Epoch

This implementation uses a default epoch of 2016-01-01 as of release `v1.0.0`.

Increasing the epoch value _decreases_ the base value of the generated IDs.


# Usage

```PHP
<?php

require "simpleflake.php";

$newId = \simpleflake\generate();
echo "ID: $newId\n";

$parts = \simpleflake\parse($newId);
echo "Timestamp:  " . $parts["timestamp"] . "\n";
echo "RandomBits: " . $parts["randomBits"] . "\n";
```


# Resources

#### Related Projects

* [SawdustSoftware/simpleflake](https://github.com/SawdustSoftware/simpleflake) (Python)
* [bwmarrin/snowflake](https://github.com/bwmarrin/snowflake) (Golang)
* [leodutra/simpleflakes](https://github.com/leodutra/simpleflakes) (NodeJS)
* [twitter/snowflake](https://github.com/twitter/snowflake) (project retired)

#### Articles and Presentations

* [Announcing Snowflake](https://blog.twitter.com/engineering/en_us/a/2010/announcing-snowflake.html)
* [A Better ID Generator For PostgreSQL](https://rob.conery.io/2014/05/28/a-better-id-generator-for-postgresql/)
* [Unique ID generation in distributed systems](https://www.slideshare.net/davegardnerisme/unique-id-generation-in-distributed-systems)
* [Fast ID Generation](http://blog.paracode.com/2012/04/16/fast-id-generation-part-1/)
