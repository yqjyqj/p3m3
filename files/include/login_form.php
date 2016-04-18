<p>Login with username and password.</p><br>
<form action="login.php" method="post">
            <label for "username">Username:</label>
            <input type='text' id='username' name='username'>
            <?php if(isset($_POST['username'])  and empty($_POST['username'])){
            print ("<p class='error'>Please enter a username!</p>");
            }
            ?><br><br>
            <label for "password">Password:</label>
            <input type='password' id='password' name='password'><?php if(isset($_POST['password'])  and empty($_POST['password'])){
            print ("<p class='error'>Please enter a password!</p>");
            }
            ?><br><br>
            <input type="submit" id='submit' name='submit' value="Submit"><br><br>
            <p class='error' id='ajax_error'></p>
        </form>
