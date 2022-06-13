<?php


function deleteAll($str)
{
    //It it's a file.
    if (is_file($str)) {
        //Attempt to delete it.
        return unlink($str);
    }
    //If it's a directory.
    elseif (is_dir($str)) {
        //Get a list of the files in this directory.
        $dir = substr($str, 3);
        if (!in_array($dir, ["php-deploy", "logs", "usage"])) {

            $scan = glob(rtrim($str, '/') . '/*');
            //Loop through the list of files.
            foreach ($scan as $index => $path) {
                //Call our recursive function.
                deleteAll($path);
            }
            //Remove the directory itself.
            return @rmdir($str);
        }
    }
}

function copyrecursive($source, $destination)
{
    // Get array of all source files
    $files = scandir($source);
    // Cycle through all source files
    foreach ($files as $file) {
        if (in_array($file, array(".", ".."))) continue;
        if (is_dir($source . $file)) {
            mkdir($destination . $file);
            copyrecursive($source . $file, $destination . "/" . $file);
        } else if (is_dir($source . "/" . $file)) {
            mkdir($destination . "/" . $file);
            copyrecursive($source . "/" . $file, $destination . "/" . $file);
        } else {
            // If we copied this successfully, mark it for deletion
            if (copy($source . "/" . $file, $destination . "/" . $file)) {
                $delete[] = $source . $file;
            }
        }
    }
}
