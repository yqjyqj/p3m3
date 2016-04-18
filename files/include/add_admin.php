<p>Add an album here:</p><br>
    <form action="add.php" method="post">
        <label for="new_title">New album title: </label>
        <input name="new_title">
        <input type="submit" value="Add album"><br><br>
       <?php if(isset($_POST['new_title'])  and strlen($_POST['new_title'])>30){
        print ("<p class='error'>Title cannot be longer than 30 characters!</p>");
        }
        if(isset($_POST['new_title'])  and empty($_POST['new_title'])){
        print ("<p class='error'>Please enter a title!</p>");
        }
        ?> 
    </form>
        </div>

    <!--Upload a photo-->
    <div class="description">
    <form action="add.php" method="post" enctype="multipart/form-data">
        <!--photo_upload-->
        <p>Upload a photo here:</p><br>
                <input id="new-photo" type="file" name="newphoto"><br><br>
        <!--date_taken-->
        <label for="date_taken">Date Taken: (YYYY-MM-DD) </label>
        <input name='date_taken' class='datepicker'><?php if(isset($_POST['date_taken'])  and empty($_POST['date_taken'])){
    print ("<p class='error'>Please enter a date!</p>");
        }
            ?><br><br>
        <!--location_name-->
        <label for="location_name">Location Name: </label>
        <input name='location_name'><br><br>
    <!--description-->
        <label for="description">Description: </label><br>
        <textarea name='description'></textarea><?php if(isset($_POST['description'])  and empty($_POST['description'])){
    print ("<p class='error'>Please enter a description!</p>");
        }
            ?>
        <br><br>
        <label for="albumID">Add the image to album:</label><br><br>
        <select name="albumID">
            <option value="NoSelection"></option>
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
        
        </select><br><br>
    <!--submission-->
                <input type="submit" value="Upload photo">
        </form>