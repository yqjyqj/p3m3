<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css">
    <title>Albums</title>
    <?php
        include "include/links.php";
        include "include/functions.php";
        
    ?>
</head>
    <?php
include "include/config.php";
 global $ID;

    ?>
	
<body>
<form method='post', action='albums.php'>
<?php include "include/banner.php";

?>
    <div class="description">
<!--Form that takes user-selected album!-->
        
        <p>To get started, first select an album, then click "Display" to view or click "edit" to edit album title. Select a photo from slideshow to view or edit the selected photo.</p><p>You must be logged in to use the editing feature.</p><br><br>
        
        <label for="new-photo">Select an album:</label><br><br>
        <select name="albumID">
        <?php
        if(isset($_POST['albumID'])){
            $ID=$_POST['albumID'];
            print "<option value=$ID></option>";
        }
        ?>
	    <option value="ShowAll">Show all albums</option>
	<?php
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
    //query that counts the number of albums in the database.
    $check_albums = $mysqli->query('SELECT albumID, title
    FROM Albums');
    while($all_albums=$check_albums->fetch_assoc()){
        $albumID=$all_albums['albumID'];
        $title=$all_albums['title'];
        print "<option value=$albumID>$title</option>";
    }
        
    ?>
        
	    </select>
    <input type="submit" name="submit" value='Display'/>
    <!--!!admin option!!-->
    <?php
    if(isset($_SESSION['logged_user'])){
        print "<input type='submit' name='edit' value='edit'>  ";
        print "<input type='submit' name='album_delete' value='Delete Album'>";
    }
    ?>
        
<!--end of form-->
    </div>
<!--form with all user editing features.-->
    <div class='description'>
    
    <?php
    //$ID is global id for current album.
$update_album='';   
//if admin clicks "edit", display album title to be edited
if(isset($_POST['edit']) and isset($_POST['albumID']) and $_POST['albumID']!=="ShowAll"){
    $ID=$_POST['albumID'];
     $update_album=$ID;
    //input title of the selected album.
    $check_photos = $mysqli->query("SELECT title
    FROM Albums WHERE albumID='$ID'");
    //display here: name of the selected album
    $row=$check_photos->fetch_row();
    print "<label for 'user_title'>Enter to edit Album Title:</label><br><br>";
    print "<input name='user_title' value='$row[0]'><br><br>";
    print "<input type='submit' name='album_edit' value='Edit'>  ";
    
    
}

 print_r($update_album);
//deleting album
if(isset($_POST['album_delete'])){
    
    $delete_title=$mysqli->query("DELETE Albums, Photo_in_album FROM
Albums LEFT OUTER JOIN Photo_in_album
On Albums.albumID=Photo_in_album.albumID
WHERE Albums.albumID=$ID");
    if($delete_title){
        print "<p>Successfully deleted album!</p>";
    }
    else{
        print "<p>Album not deleted!</p>";
    }

}

    //editing album name
if (isset($_POST['album_edit'])){

       
        $user_title=filter_input( INPUT_POST, 'user_title', FILTER_SANITIZE_SPECIAL_CHARS);
        print_r($user_title);
        print_r ($ID);
        $edit_title=$mysqli->query("UPDATE Albums
        SET title='$user_title'
        WHERE albumID=$ID");
        if($edit_title==true){
            print "<p>Album title edited successfully!</p>";
        }
        else{
            print "<p>Album title not edited successfully!</p>";
        }
    }
    

print "</div>";

//display image records in selected album
    


//if user has selected an album, display the album      
if(isset($_POST['albumID']) and $_POST['albumID']!=="ShowAll") {
    $ID=$_POST['albumID'];
include "include/display_album.php";
}

//if user has not selected an album, display all albums
elseif (isset($_POST['albumID']) and $_POST['albumID']=="ShowAll"){
    $check_albums = $mysqli->query('SELECT albumID, title
FROM Albums');
     while($all_albums=$check_albums->fetch_assoc()){
        
        $ID=$all_albums['albumID'];
         include "include/display_album.php";
}
}

//photo edit area
include "edit_images.php";

?>


  
   
    <div class="footer">
    <?php
        include "include/footer.php";
?>
    </div>
</form>
    </body>
</html>