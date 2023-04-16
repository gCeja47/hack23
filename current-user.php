<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: by Sharon Tuttle, last modified 2023-02-22 -->

<!--
    by: Gracie Ceja
    last modified: April 15, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/hackathon/current-user.php
-->

<head>
    <title>HSU Dating Website: Current User &hearts; </title>
    <meta charset="utf-8" />

    <!-- favicon for this website -->
    <link href="favicon3.png" type="image/x-icon" rel="icon">

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

    <!-- css for this website  -->
    <link href="main.css" type="text/css" rel="stylesheet" />


</head>

<body>
    <h1>Humboldt Students of University Dating Website &hearts; </h1>
    <nav> <a href="index.html">Home</a> <a href="about.html">About</a> 
        <a href="profiles.php">View Profiles</a> <a href="current-user.php">Login/out & Account Info</a> 
        <a href="new-user.php">Sign up/Create Account</a> </nav>

    <?php
    // user is not logged in, due to no session or login failure or logged out
    if(!isset($_SESSION["username"]) || $_SESSION["state"] == "login"){     
    ?>
        <h1>Log In</h1>
        <p>Please login (your username should match yours from the university, but your password shouldn't).</p>

        <form method="post" action="current-user.php">
            <label for="usr">Username:</label>
            <input type="text" name="username" id="usr" />

            <label for="psd">Password:</label>
            <input type="password" name="password" id="psd" />
            
            <input type="submit" value="Log In" />
        </form>


    <?php
    }   // end of if
    // user has attempted to login
    elseif($_SERVER["REQUEST_METHOD"] == "POST"){   
    ?>



    <?php  
    }   // end of first elseif
    // user is logged in now
    elseif($_SESSION["state"] == "in"){
    ?>
    <h1>Welcome, <?= $_SESSION["username"] ?>!</h1>
    <form method="post" action="current-user.php">
        <label for="selection">What would you like to do?</label>
        <select name="userchoice" id="selection">
            <option value="view-profiles">View Profiles</option>
            <option value="search-profiles">Search Profiles</option>
            <option value="view-acct">View Account Info</option>
            <option value="edit-acct">Edit Account Info</option>
            <option value="log-out">Log Out</option>
        </select>
        <input type="submit" value="Submit Choice" />
    </form>


    <?php  
    }   // end of second elseif
    ?>





    <footer>
        <hr />
        <p>NOTE: This is NOT an official product/website/app of Cal Poly Humboldt, 
            this a Hackathon project by a student. &copy; 2023 Gracie Ceja </p>
    </footer>
</body>
</html>
