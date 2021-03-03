--TEST--
Report success with a valid php code
--FILE--
<?php

$checkRunner = require __DIR__ . '/init.php';

$checkRunner('tests/assets/good-lp-program.md');

--EXPECTF--
Finding documentation files on tests/assets/good-lp-program.md


     Everything is OK!
