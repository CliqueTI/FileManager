<?php

    /* Auto Load */
    require __DIR__."/../vendor/autoload.php";

    /* Alias */
    use CliqueTI\FileManager\File;

    /* Get Content */
    $file = new File('./');

    echo "Update on: {$file->getPath()}example-update.txt";
    $file->update('example-update.txt', "run on: ".date("Y-m-d H:i:s")."\n");
