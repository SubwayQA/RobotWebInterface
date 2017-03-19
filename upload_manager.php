<?php
if(isset($_FILES["hex_file"]["error"])){
    if($_FILES["hex_file"]["error"] > 0){
        echo "Error: " . $_FILES["hex_file"]["error"] . "<br>";
    } else{
        $filename = $_FILES["hex_file"]["name"];
        $filetype = $_FILES["hex_file"]["type"];
        $filesize = $_FILES["hex_file"]["size"];
    
        // Check whether file exists before uploading it
        if(file_exists("/home/pi/uploads/" . $_FILES["hex_file"]["name"])){
            echo $_FILES["hex_file"]["name"] . " is already exists.";
        } else{
            move_uploaded_file($_FILES["hex_file"]["tmp_name"], "/home/pi/uploads/" . $_FILES["hex_file"]["name"]);
	    
            echo "<h4>Information about uploaded file:</h4><br>";
            echo "<b>Name: </b>" . $filename . "<br>";
            echo "<b>Type: </b>" . $filetype . "<br>";
            echo "<b>Size: </b>" . $filesize . "<br>";
        } 
        
    }
} else{
    echo "Error: Invalid parameters - please contact your server administrator.";
}
?>