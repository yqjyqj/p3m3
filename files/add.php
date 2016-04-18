<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css">
    <title>Add Photos</title>
    <?php
    include "include/links.php";
    include "include/config.php";
    include "include/functions.php";
    include "include/resize.php";
?>
</head>
    <div class="banner">
        <h1>Add</h1>
        <p><span><a href="../index.php">Introduction</a> | <a href="albums.php">Albums</a> | <a href="search.php">Search</a> | <a href="add.php">Add</a> | <a href="login.php">Login</a></span></p>
    </div>
<body>
    <!--add an album-->
    <div class="description">
    <?php
    if(isset($_SESSION['logged_user'])){

    include "include/add_admin.php";
    }
    else{
        print "<p>You must be logged in to add an album.</p>";
    }
    ?>
        </div>
        
        
<?php
    //start checking album title input
    if(isset($_POST['new_title']) and !empty ($_POST['new_title']) and strlen($_POST['new_title'])<=30){
        $new_title=filter_input( INPUT_POST, 'new_title', FILTER_SANITIZE_SPECIAL_CHARS);
        $newdate = date('Y-m-d');
    //open mysql connection:
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->error) {
            print($mysqli->connection_error);
            exit();
        }
    //query that inserts the new album into "Albums"
        $add_album=$mysqli->query("
        INSERT INTO Albums(title, date_created) VALUES ('$new_title','$newdate')");
        print ("<p class='description'> New album: $new_title Successfully added!</p>");
    }
    
    //


?>

    
    
<?php
    //start checking if non-optional inputs are valid
if(isset($_FILES['newphoto']) and isset($_POST['date_taken']) and isset($_POST['description'])){
    if (!empty($_FILES['newphoto']) and check_date_format($_POST['date_taken'])==true
        and strlen($_POST['description'])<=300)
         {
        //initialize variables to be inserted into database(image paths are temporary)
        $description=filter_input( INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $date_taken=filter_input( INPUT_POST, 'date_taken', FILTER_SANITIZE_SPECIAL_CHARS);
        $date_added = date('Y-m-d'); //get today's date
        $location_name=filter_input( INPUT_POST, 'location_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $temporary_file_path='../images/Photos/';//temporary file path
        $temporary_thumbnail_path='../images/Photos/';//temporary thumbnail_path
        $newPhoto = $_FILES['newphoto'];//read file information
        $path=$newPhoto['name'];//get file name
        $ext = pathinfo($path, PATHINFO_EXTENSION);//extract extension from file name
        $tempName = $newPhoto['tmp_name'];//get temporary storage
    
        //open mysql connection:
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->errno) {
            print($mysqli->connection_error);
            exit();
        }
        //insert photo information into DB (with temporary image paths)
        $add_photo=$mysqli->query("INSERT INTO Photos(date_taken, date_added, location_name, description, file_path, thumbnail_path) 
            VALUES ('$date_taken','$date_added','$location_name','$description', '$temporary_file_path','$temporary_thumbnail_path')"
            );
        //retrieve photoID of the inserted entry

        $ID=$mysqli->insert_id;

        //update the file_path of photo using the photoID retrieved
        $new_file_path=$temporary_file_path.$ID.'.'.$ext;


        //move the photo to the file_path


            if ( $newPhoto['error'] == 0 ) {
                    move_uploaded_file($tempName, $new_file_path);
                    print("<p class='description'>The file was uploaded successfully.</p>");

                } 
            else {
                    print("<p>Error: The file $originalName was not uploaded.</p>");
            }
        $update_file_path=$mysqli->query("UPDATE Photos SET file_path='$new_file_path' WHERE photoID=LAST_INSERT_ID()");
        
        //get a thumbnail of the saved image, and update the thumbnail path on DB.
        $new_thumbnail_path=$temporary_thumbnail_path.$ID.'_thumb.'.$ext;
        save_thumbnail($new_file_path, $new_thumbnail_path, 400);
        $update_thumbnail_path=$mysqli->query("UPDATE Photos SET thumbnail_path='$new_thumbnail_path' WHERE photoID=LAST_INSERT_ID()");
     
        //display the uploaded photo
        print("<div class='description'><img src='$new_thumbnail_path'></div>");
     }

        //if the user selected an album for the photo, get the albumID selected
     if($_POST['albumID']!=='' and isset($ID)){
        $albumID=$_POST['albumID'];
        $insert_into_album=$mysqli->query("INSERT INTO Photo_in_album (photoID, albumID)
            VALUES ('$ID', '$albumID')");
     }
     //if inputs are not valid, print alert message
     else{
        print ("<p class='description'>Photo not uploaded! Please check.</p>");
     }}


 
?>
    </body>
</html>