<?php

    // unzip the file
    $zip = new ZipArchive;
    $zip->open('artifacts.zip');
    $zip->extractTo('./');
    $zip->close();
