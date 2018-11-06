<?php
require_once ("database.php");

//get the values from the form
$name= filter_input(INPUT_POST, "name");
$email= filter_input(INPUT_POST, "email");
$pass= filter_input(INPUT_POST, "pass");

$image_name = basename($_FILES["fileToUpload"]["name"]);
$query = "insert into users
    (name,email,password,avatar)"
        ." VALUES 
        (:np_name, :np_email, :np_pass, :np_img)";
$statement = $link->prepare($query);
$statement->bindValue(":np_name",$name);
$statement->bindValue(":np_email",$email);
$statement->bindValue(":np_pass",$pass);
$statement->bindValue(":np_img",$image_name);
$statement ->execute();
$statement->closeCursor();

//$sql = "INSERT INTO `product_images` (`id`, `image`, `image_name`) VALUES ('1', '{$image}', '{$image_name}')";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   if($check !== false) {
    //  echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
       echo "File is not an image.";
        $uploadOk = 0;
    }
}
//// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
//// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if( $imageFileType != "png" ) {
    echo "Sorry, only PNG files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
       echo "Sorry, there was an error uploading your file.";
   }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
     
        <a href="index.php">back<br></a>
        <img src="uploads/<?php echo $image_name; ?>">
    
    </body>
</html>
