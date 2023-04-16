<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: by Sharon Tuttle, last modified 2023-02-22 -->

<!--
    by: Gracie Ceja
    last modified: April 15, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/hackathon/profiles.php
 
-->

<head>
    <title>HSU Dating Website: Profiles &hearts; </title>
    <meta charset="utf-8" />

    <!-- favicon for this website -->
    <link href="favicon3.png" type="image/x-icon" rel="icon">

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

    <!-- css for this website  -->
    <link href="main.css" type="text/css" rel="stylesheet" />


    <?php
        require_once("table-public-users.php");
        require_once("list-public-users.php");
        require_once("search-users-form.php");
    ?>


</head>

<body>
    <h1>Humboldt Students of University Dating Website &hearts; </h1>
    <nav> <a href="index.html">Home</a> <a href="about.html">About</a> 
        <a href="profiles.php">View Profiles</a> <a href="current-user.php">Login/out & Account Info</a> 
        <a href="new-user.php">Sign up/Create Account</a> </nav>

    <?php
    if(!isset($_SESSION["username"]) && !isset($_SESSION["searchstate"])){
        ?>
        <h2>View Public Profiles</h2>
        <p>Even though you are not logged in, you may view and search the profiles of people who have decided
            to make their profiles public. However, the data may be a bit out of date. Last update is: 
            <span class="time">never</span>.
        </p>

        <?php
        search_users();
        ?>

        
        <?php
        public_list();
        ?>




    <?php
    }
    else{
        ?>
        <h2>View Profiles</h2>
        <p>Since you are logged in, you may view all profiles (except for those of people who have blocked you).
            You may also search profiles, mark someone as your crush (they will only be notified if it is mutual!),
            as well as send messages to other users.
        </p>

        <?php
        private_list();
        ?>



      
    <?php  
    }
    ?>

    

        





    <footer>
        <hr />
        <p>NOTE: This is NOT an official product/website/app of Cal Poly Humboldt, 
            this a Hackathon project by a student. &copy; 2023 Gracie Ceja </p>
    </footer>
</body>
</html>
