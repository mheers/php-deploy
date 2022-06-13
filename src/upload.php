<?php
$token = "my-secret-token";
$debug = true;

if($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


if(!array_key_exists('token', $_GET)) {
    http_response_code(401);
    echo "no token found";
    die();
}

if($_GET['token']!=$token) {
    http_response_code(403);
    echo "token not valid";
    die();
}

// print_r($_SERVER);
// print_r($_FILES);

if(!array_key_exists('data', $_FILES)) {
    echo "no data received";
    die();
}

else {
    // get uploaded file
    $uploaddir = './';
    $uploadfile = $uploaddir . basename($_FILES['data']['name']);
    if (move_uploaded_file($_FILES['data']['tmp_name'], $uploadfile)) {
        // echo "file uploaded successfully.\n";
    } else {
        http_response_code(500);
        echo "could not upload the file!\n";
        exit();
    }
    
    if($debug) print_r($_FILES);
    
    // unzip the file
    $zip = new ZipArchive;
    if ($zip->open('artifacts.zip') === TRUE) {
        $zip->extractTo('./');
        $zip->close();
    } else {
        http_response_code(500);
        echo 'could not extract archive';
        exit();
    }

    // delete old files
    deleteAll('../');
    
    // deploy the new files
    copyrecursive("./public/", "../");
    
    // remove now orphan artifacts
    deleteAll('./public/');
    unlink('./artifacts.zip');

    http_response_code(200);
    echo "deployed successfully";
}




#curl -F 'data=@/tmp/artifacts.zip' 'http://localhost/php-deploy/upload.php?token=test'
