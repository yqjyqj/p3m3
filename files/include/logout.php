<?php session_start();?>
<?php
if(isset($_SESSION['logged_user'])){
	unset($_SESSION['logged_user'] );
	print "<p>You are successfully logged out.</p>";
	print "<p><a href='../login.php'>Log in again</a></p>";
}
?>