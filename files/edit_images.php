
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-rg0h{font-size:12px;text-align:center;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
<!--This form takes the value of the current broswing photo title-->
<div class='description' action='albums.php'>

    <label for='title'>Selected Photo:</label><br><br>
    <input name='hidden_title' class='hidden' value="<?php
        if(isset($_POST['title'])){
            $saved_title=$_POST['title'];
            print $saved_title;
        }?>">
    <input name="title" id="title" size="50" value="">
    <input type='submit' name='photo_edit' value='View/Edit'>
    <input type='submit' name='photo_delete' id='delete' value='Delete this photo!'>
    <br><br>

    
    
<table class="tg" width='900px'>
    <!--set up the table header-->
  <tr>
    <th class="tg-yw4l">Photo ID</th>
    <th class="tg-yw4l">Date photo was taken</th>
    <th class="tg-yw4l">Name of the location</th>
    <th class="tg-yw4l">Tag</th>
      <th class="tg-yw4l">Description</th>
    <th class="tg-yw4l">Edit?</th>

  </tr>

  <?php
 

    //first obtain the records of images in the selected album.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->errno) {
            print($mysqli->error);
            exit();
        }
    //display photo information with editable fields.
      if(isset($_POST['title']) and isset($_POST['photo_edit']) and isset($_SESSION['logged_user'])){
        $title=$_POST['title'];
        $check_photo = $mysqli->query("SELECT * FROM Photos
        WHERE description='$title'");
    
        while($row=$check_photo->fetch_assoc()){
            $date_taken=$row['date_taken'];
            $location_name=$row['location_name'];
            $tag=$row['tag'];
            $description=$row['description'];
        $thumbnail_path=$row['thumbnail_path'];
    
                $photoID=$row['photoID'];
            print "<tr><th class='tg-yw4l'>$photoID";
            print "<th class='tg-yw4l'><input name='date_taken' class='datepicker' value=$date_taken></th>";
            print "<th class='tg-yw4l'><input name='location_name' value=$location_name></th>";
            print "<th class='tg-yw4l'><input value='$tag' name='tag'></th>";
            print "<th class='tg-yw4l'><input value='$title' name='description'></th>";
            print "<th class='tg-yw4l'><input type='submit' name='action_edit' value='edit'></th>";
          
            
    }
        
          
}
//display photo information with non-editable fields
global $photoID;
if(isset($_POST['title']) and isset($_POST['photo_edit']) and (isset($_SESSION['logged_user']))==false){
        $title=$_POST['title'];
        $check_photo = $mysqli->query("SELECT * FROM Photos
        WHERE description='$title'");
    
        while($row=$check_photo->fetch_assoc()){
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
            print "<th class='tg-yw4l'>$title</th>";
            print "<th class='tg-yw4l'>Please login</th>";
           
            
    }
        
          
}

//edit photo entries
if (isset($_POST['action_edit']) and isset($_POST['hidden_title'])){
    $hidden_title=$_POST['hidden_title'];
    if(isset($_POST['date_taken']) and check_date_format($_POST['date_taken'])==true and !empty($_POST['location_name']) and strlen($_POST['description'])<=300){
        //start sanitizing input
        $date_taken=$_POST['date_taken'];
        $tag=filter_input( INPUT_POST, 'tag', FILTER_SANITIZE_SPECIAL_CHARS);
        $description=filter_input( INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $location_name=filter_input( INPUT_POST, 'location_name', FILTER_SANITIZE_SPECIAL_CHARS);
        //update database.
        $query="UPDATE Photos SET date_taken='$date_taken', location_name='$location_name', tag='$tag', description='$description' WHERE description='$hidden_title'";

        $update_photo=$mysqli->query($query);
   
        if($update_photo==true){
            print "<p>Record Updated!</p><br><br>";
        }
        else{
            print "<p>Error updating record!</p><br><br>";
        }
}
    
    else{
        print "<p class='error'>Please check your input!</p>";
    }
}
//delete selected photo record. Works 
         
if(isset($_POST['title']) and isset($_POST['photo_delete']) and isset($_SESSION['logged_user'])){
$title=$_POST['title'];
$select_photo = $mysqli->query("SELECT * FROM Photos
        WHERE description='$title'");

    $delete_photo_in_album=$mysqli->query("
DELETE Photos, Photo_in_album
FROM Photos
LEFT OUTER JOIN Photo_in_album ON Photos.photoID=Photo_in_album.photoID
WHERE description='$title'");
    if($delete_photo_in_album==true){
        print "<p>Photo successfully deleted!</p>";
    }

}
//if user not logged in, alert message
if(isset($_POST['photo_delete']) and (isset($_SESSION['logged_user']))==false){
    print "<p class='error'>Please login first!</p><br><br>";
}

    
  ?>

 </table>
</div>

 

 
