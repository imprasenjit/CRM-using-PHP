<?php
$targetFolder = "../../storage/temps/"; // Relative to the root

if(!empty($_FILES)) {
    foreach($_FILES as $key=>$file) {
        $tempFile = $file["tmp_name"];
        $targetPath = dirname(__FILE__) . "/" . $targetFolder;
        $targetFile = rtrim($targetPath,"/") . "/" . $file["name"];

        $fileTypes = array("jpg", "jpeg", "gif", "png", "pdf", "sql", "docx", "JPG", "JPEG", "GIF", "PNG", "PDF", "SQL", "DOCX"); // File extensions
        $fileParts = pathinfo($file["name"]);
        $response = array ();
        if (in_array($fileParts["extension"],$fileTypes)) {
            move_uploaded_file($tempFile,$targetFile);
            $response["success"] = 1;
            foreach ($_POST as $key => $value){
                    $response[$key] = $value;
            }
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["error"] = "Invalid file type.";
            echo json_encode($response);
        } // End of if else
    } // End of foreach
} // End of if
