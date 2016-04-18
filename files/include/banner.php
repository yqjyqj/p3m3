<div class="banner">
        <h1>Albums</h1>
        <p><span><a href="../index.php">Introduction</a> | <a href="albums.php">Albums</a> | <a href="search.php">Search</a> | <a href="add.php">Add</a> | <a href="login.php">Login</a>
        <?php
        if(isset($_SESSION['logged_user'])){
            print " | <a href='include/logout.php' id='logged_in'>Logout</a>";
        }
        ?>
        </span></p>
    </div>