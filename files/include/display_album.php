<?php

//query for information of an album.
        $individual_album = $mysqli->query("Select file_path, description, title, thumbnail_path, Locations.location_name
FROM
Locations RIGHT OUTER JOIN Photos
ON Locations.location_name = Photos.location_name
INNER JOIN Photo_in_album
ON Photos.photoID = Photo_in_album.photoID
INNER JOIN Albums
ON Albums.albumID=Photo_in_album.albumID
WHERE Albums.albumID='$ID'");
        print "<div class='description' class='box'>";
    $check_title = $mysqli->query("SELECT title
FROM Albums WHERE albumID='$ID'");
    $print_title=$check_title->fetch_row();
        print "<h3>$print_title[0]</h3><br>";
            $found_album = $individual_album->fetch_assoc();
            $file_path=$found_album['file_path'];
            $description=$found_album['description'];
            $thumbnail_path=$found_album['thumbnail_path'];
            $location_name=$found_album['location_name'];
            print ("<a rel='gallery' title='$description' class='fancybox' href='$file_path'><img src='$thumbnail_path' alt=''/></a>");
            print ("<p>Click the image to start slideshow.</p></div>");
            

        while ($found_album = $individual_album->fetch_assoc()) {
            $file_path=$found_album['file_path'];
            $description=$found_album['description'];
            $thumbnail_path=$found_album['thumbnail_path'];
            print ("<div class='hidden'>");
            print ("<a rel='gallery' title='$description' class='fancybox' href='$file_path'><img src='$thumbnail_path' alt=''/></a>");
            print ("</div>");
            
        }
         print ("</div></div>");

?>