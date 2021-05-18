<?php

    /* Auto Load */
    require __DIR__."/../vendor/autoload.php";

    /* Alias */
    use CliqueTI\FileManager\File;

    /* Get Content */
    $file = new File('./');

    echo "Write on: {$file->getPath()}example-write.txt";
    $file->write('example-write.txt', "run on: ".date("Y-m-d H:i:s"));
