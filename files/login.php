<?php session_start();?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../css/stylesheet.css" rel="stylesheet" type="text/css">
    <?php include "include/links.php";
    include "include/config.php";
    include "include/functions.php";
    include "include/resize.php";
    ?>
    <title>Login</title>
</head>
<body>
	<?php include "include/banner.php";?>
    <div class="description">
        <div id='login'>
        
        <!--login/registration form-->
        <?php 
        if(!isset($_SESSION['logged_user'])){
            include "include/login_form.php";
        }
        ?>
        </div>
        <?php
        if(isset($_POST['submit'])){
            if (!empty($_POST['password']) and !empty ($_POST['username'])){
                $username=$_POST['username'];
                $password=$_POST['password'];
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                if ($mysqli->errno) {
                    print($mysqli->error);
                    exit();
                }
                $check_login = $mysqli->query("SELECT password
                FROM Users WHERE username='$username'");
                if ($check_login && $check_login->num_rows == 1){
                    $row = $check_login->fetch_assoc(); 
                    $db_hash_password = $row['password']; 
                    if( password_verify($password, $db_hash_password) ) {
                        $_SESSION['logged_user'] = $username; 
                    }
                    else{
                        print ("<p>Unable to login with the given information!</p>");
                    }
                }
                else{
                    print ("<p>Cannot find login information.</p>");
                }
            }
        }
        if (isset($_SESSION['logged_user'])){
            print "<p id='success'>Congratulations, you are logged in.</p><br>";
            print "<p id='success'>To edit albums and images, go to <a href='albums.php'>Albums</a></p><br>";
            print "<p id='success'>To add a new image or album, go to <a href='add.php'>Add</a></p><br>";
            print "<p><a href='include/logout.php'>Log me out</a></p>";
        }      
        ?>
    </div>

    </body>
</html>