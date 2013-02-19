<?php

require_once __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(
        function ($className) {
            $file = str_replace('\\', '/', $className);
            $file = __DIR__ . '/../src/' . $file . '.php';
            if (is_file($file)) {
                require_once $file;
            } else {
                echo $file . ' not found' . PHP_EOL;
            }
        }
);