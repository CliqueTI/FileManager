<?php

    /* Auto Load */
    require __DIR__."/../vendor/autoload.php";

    /* Alias */
    use CliqueTI\FileManager\File;

    /* Get Content */
    $file = new File('./');

    echo "From Json:";
    $content = $file->readFromJson('example.json');
    var_dump($content);
    echo "<hr>";

    echo "From Text:";
    $content = $file->read('example.json');
    var_dump($content);
    echo "<hr>";

    echo "By Line:";
    $content = $file->readByLine('example-by-line.txt');
    var_dump($content);
    echo "<hr>";

