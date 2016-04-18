

<!--display fields for the selected album entry in DB-->
<div class='description'>

	<?php
	//find the selected album
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->errno) {
            print($mysqli->error);
            exit();
        }
    //query that counts the number of albums in the database.
    $check_photos = $mysqli->query("SELECT title
	FROM Albums WHERE albumID='$ID'");
    //display here: name of the selected album
	$row=$check_photos->fetch_row();
	print "<label for 'title'>Enter to edit Album Title:</label><br><br>";
	print "<input name='title' value='$row[0]'><br>";
	print "<input type='submit' name='album_edit' value='Edit'>"
	
	?>

</div>