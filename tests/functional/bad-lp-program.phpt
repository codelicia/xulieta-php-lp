--TEST--
Report failure with an valid php code
--FILE--
<?php

$checkRunner = require __DIR__ . '/init.php';

$checkRunner('tests/assets/bad-lp-program.md');

--EXPECTF--
Finding documentation files on tests/assets/bad-lp-program.md

 --> tests/assets/bad-lp-program.md
 1 |
 2 |   <?php
 3 |   echo "Error is near";
 4 |   echo "Hello Mom! I'm doing Literate Programing in PHP"  \ . PHP_EOL;
   |  __________________________________^
   | |
     = note: Syntax error, unexpected T_NS_SEPARATOR, expecting ';' on line 4


     Operation failed!
