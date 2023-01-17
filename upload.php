<?php
if (!$_FILES["uploadingfile"]["tmp_name"]) {//No file chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
 else {
    $extension = pathinfo($_FILES['uploadingfile']['name'], PATHINFO_EXTENSION);
    if ((($_FILES["uploadingfile"]["type"] == "video/mp4")) && $extension == 'mp4') {
        
        //Directory to put file into
        $folderPath = "uploads/";
        
        //File name
        $original_file_name = $_FILES["uploadingfile"]["name"];
        
        $size_raw = $_FILES["uploadingfile"]["size"];//File size in bytes
        
        $size_as_mb = number_format(($size_raw / 1048576), 2);//Convert bytes to Megabytes
        
        if (move_uploaded_file($_FILES["uploadingfile"]["tmp_name"], "$folderPath" . $_FILES["uploadingfile"]["name"] . "")) {
            
            //Move file
            echo "$original_file_name upload is complete";
        }
    } else {
        echo "File is not a MP4";
        exit;
    }
}