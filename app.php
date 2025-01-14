<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $result = main();
    echo $result;
} catch (Exception $e) {
    echo handleError($e->getMessage());
}

