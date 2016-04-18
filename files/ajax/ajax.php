
<?php
include "../include/config.php";
if (isset($_POST['keyup_username'])){
	$keyup_username=$_POST['keyup_username'];
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->errno) {
            print($mysqli->error);
            exit();
        }
        $check_login = $mysqli->query("SELECT password
        FROM Users WHERE username='$keyup_username'");
        $row_num=$check_login->num_rows;
        print (
        	'{"row_num": '+$row_num+'}'
        	)
        	;
};
?>