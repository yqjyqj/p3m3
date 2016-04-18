<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css">
    <?php
    include "include/links.php";
    include "include/config.php";
    include "include/functions.php";
    include "include/resize.php";
?>
    <title>Search</title>
</head>

<body>
	<div class="banner">
        <h1>Search for Photos</h1>
        <p><span><a href="../index.php">Introduction</a> | <a href="albums.php">Albums</a> | <a href="search.php">Search</a> | <a href="add.php">Add</a> | <a href="login.php">Login</a></span></p>
    </div>
    <div class="description">
    <p>Search with: album titles, photo descriptions, tags, and location names.</p><br><br>
    <form method='post' action='search.php'>
        <label for='album_search'>Search for albums:</label>
        <input type='text' name='album_search' value='<?php
        if(isset($_POST['album_search']) and !empty($_POST['album_search'])){
            $album_search=$_POST['album_search'];
            print $album_search;
        }?>'
        ><br><br>
        <label for='photo_search'>Search for photos:</label>
        <input type='text' name='photo_search'  value='<?php
        if(isset($_POST['photo_search'])and !empty($_POST['photo_search'])){
            $photo_search=$_POST['photo_search'];
            print $photo_search;}?>'
        >
        <input type='submit' name='search' value='Search!'><br><br>
    </form>
</div>
<div class='description'>
    <h3>Photos:</h3><br><br>
     <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-rg0h{font-size:12px;text-align:center;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>

    <table class="tg" width='900px'>
    <!--set up the table header-->
  <tr>
    <th class="tg-yw4l">Photo ID</th>
    <th class="tg-yw4l">Date photo was taken</th>
    <th class="tg-yw4l">Name of the location</th>
    <th class="tg-yw4l">Tag</th>
      <th class="tg-yw4l">Description</th>
  </tr>

    <?php
        if (isset($_POST['search']) and !empty($_POST['photo_search'])){

            $photo_search=filter_input( INPUT_POST, 'photo_search', FILTER_SANITIZE_SPECIAL_CHARS);
    
            //open sql connection
            
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($mysqli->errno) {
                print($mysqli->connection_error);
                exit();
            }

            $search_photo=$mysqli->query("SELECT * FROM Photos WHERE location_name LIKE '%$photo_search%' or description LIKE '%$photo_search%' or tag LIKE '%$photo_search%'")
            ;

            while($row=$search_photo->fetch_assoc()){
            $date_taken=$row['date_taken'];
            $location_name=$row['location_name'];
            $tag=$row['tag'];
            $description=$row['description'];
            $thumbnail_path=$row['thumbnail_path'];
            $photoID=$row['photoID'];
            print "<tr><th class='tg-yw4l'>$photoID";
            print "<th class='tg-yw4l'>$date_taken</th>";
            print "<th class='tg-yw4l'>$location_name</th>";
            print "<th class='tg-yw4l'>$tag</th>";
            print "<th class='tg-yw4l'>$description</th>";
           
            
    }

        }
    ?>

   
</table>
    </div>
    <div class='description'>
        <h3>Albums:</h3><br><br>
<table class='tg' width='900px'>
        <tr>
    <th class="tg-yw4l">Album ID</th>
    <th class="tg-yw4l">Title</th>
    <th class="tg-yw4l">Date Created</th>
  </tr>

   <?php
        if (isset($_POST['search']) and !empty($_POST['album_search'])){

            $album_search=filter_input( INPUT_POST, 'album_search', FILTER_SANITIZE_SPECIAL_CHARS);
    
            //open sql connection
            
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($mysqli->errno) {
                print($mysqli->connection_error);
                exit();
            }

            $search_album=$mysqli->query("SELECT * FROM Albums
WHERE title LIKE '%$album_search%'");
    
            while($row=$search_album->fetch_assoc()){
            $albumID=$row['albumID'];
            $title=$row['title'];
            $date_created=$row['date_created'];
            
            print "<tr><th class='tg-yw4l'>$albumID";
            print "<th class='tg-yw4l'>$title</th>";
            print "<th class='tg-yw4l'>$date_created</th></tr>";
           
            
    }

        }

?>

    </body>
</html>