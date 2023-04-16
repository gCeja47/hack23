<?php
    session_start();
    setcookie("cookieid", "rand(1, 5000)"); 
?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- cs328 class HTML template: by Sharon Tuttle, last modified 2023-02-22 -->

<!--
    by: Gracie Ceja
    last modified: April 16, 2023

    you can run this using the URL: https://nrs-projects.humboldt.edu/~glc47/hackathon/new-user.php
 
-->

<head>
    <title>HSU Dating Website: New User &hearts; </title>
    <meta charset="utf-8" />

    <!-- favicon for this website -->
    <link href="favicon3.png" type="image/x-icon" rel="icon">

	<!-- default css to make the webpage look nearly the same on all browsers -->
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

    <!-- css for this website  -->
    <link href="main.css" type="text/css" rel="stylesheet" />



    <?php
        require_once("hsu-conn-sess.php");
    ?>


</head>

<body>
    <h1>Humboldt Students of University Dating Website &hearts; </h1>
    <nav> <a href="index.html">Home</a> <a href="about.html">About</a> 
        <a href="profiles.php">View Profiles</a> <a href="current-user.php">Login/out & Account Info</a> 
        <a href="new-user.php">Sign up/Create Account</a> </nav>

    
    <?php
    /* user has yet to submit the form */
    if ($_SERVER["REQUEST_METHOD"] == "GET" || !isset($_COOKIE["cookieid"]) || $_SESSION["state"] == "new")
    {
    ?>
    <h2>Welcome, New User!</h2>
    <p> To create a new account, please fill in this form below. But, keep this in mind: 
        you must use your university username (but NOT your university password!) to create an account, 
        so we can use your university email to verify your account. Your email is not shown to other users 
        (unless you say so). It is used to verify that you are actually a student.
    </p>

    <form method="post" action="new-user.php" class="flexform">
        <fieldset>
            <legend>Required Info:</legend>
            <div>
                <label for="usrnm">Username:</label>
                <input type="text" name="username" id="usrnm" placeholder="abc123" />
            </div>

            <div>
                <label for="pswd">Password:</label>
                <input type="password" name="password" id="pswd" />
            </div>

        
            <div>
                <label for="perfilavailable">Do you want your profile to be publicly available 
                    (visible to those who are not logged in)?
                </label>
                <select name="profile-availability" id="perfilavailable">
                    <option value="y">Yes</option>
                    <option value="n" selected="selected">No</option>
                </select>
            </div>

        
            <div>
                <label for="emailavailable">Do you want your username to be visible to others on the website, 
                (whether they are logged in or not)?
                </label>
                <select name="hsu-email-availability" id="emailavailable">
                    <option value="y">Yes</option>
                    <option value="n" selected="selected">No</option>
                </select>
            </div>

            <div>
                <label for="edad">Please enter your age (must be at least 18):</label>
                <input type="number" name="age" id="edad" placeholder="20" min="18" max="99" step="1" />
            </div>

            <div>
                <label for="fnym">Please enter your first name:</label>
                <input type="text" name="fname" id="fnym" placeholder="Bob" />
            </div>
        </fieldset>
        <p>Other info may be added later, after your account is created.</p>


        <div>
        <input type="submit" value="Create Account" />
        </div>
    </form>
    <?php
        $_SESSION["state"] = "attempt";
    }   // end of if
    elseif($_SESSION["state"] == "attempt"){
        // get input from $_POST
        $username = strip_tags($_POST["username"]);  // sanitize input
        $passhash = password_hash($_POST["username"], PASSWORD_BCRYPT);     // hash password
        $profile_avail = strip_tags($_POST["profile-availability"]);
        $usrnm_vis = strip_tags($_POST["hsu-email-availability"]);
        $age = strip_tags($_POST["age"]);
        $fname = strip_tags($_POST["fname"]);

        // put input into session variables
        $_SESSION["newusername"] = $username;
        $_SESSION["newupasshash"] = $passhash;
        $_SESSION["newprofileavail"] = $profile_avail;
        $_SESSION["newusrnmvis"] = $usrnm_vis;
        $_SESSION["newusr-age"] = $age;
        $_SESSION["newusrfname"] = $fname;

        ?>
        <h2>Welcome, <?= $username ?>!</h2>
        <p> To create a new account, please fill in this form below. This time, you must user your oracle
            username and password to connect to the database to add your data to the database.
        </p>

        <form method="post" action="new-user.php" class="flexform">
        <fieldset>
            <legend>Required Info:</legend>
            <div>
                <label for="usrnym">Username:</label>
                <input type="text" name="username" id="usrnym" placeholder="abc123" />
            </div>

            <div>
                <label for="paswd">Password:</label>
                <input type="password" name="password" id="paswd" />
            </div>
        </fieldset>

            <div>
                <input type="submit" value="Log in to Oracle" />
            </div>
        </form>

        <?php
        $_SESSION["state"] = "oracleattempt";
    }   // end of first elseif
    elseif($_SESSION["state"] == "oracleattempt"){
        // get user's oracle login info from previous form
        $username = strip_tags($_POST["username"]);  // sanitize input
        $password = $_POST["password"];
        // put their login info into session variables
        $_SESSION["oracleusername"] = $username;
        $_SESSION["oraclepass"] = $password;

        // attempt to connect to oracle with the new user's info
        $_SESSION["state"] = "oracleattempt";   // in case oracle login fails, make user try again
        $connobj = hsu_conn_sess($username, $password);

        
        // prepare for adding new user
        $new_user_str = "insert into usertbl (user_num, username, passhash, ispublic, isusrnmpbulic,
        age, fname) values(:unum, :newusr, :uhash, :upublic, :usrnpub, :edad, :fnym)";
        $new_user_stmt = oci_parse($connobj, $new_user_str);

        $newnum = rand(1, 5000);

        // bind their entered data to the statement
        oci_bind_by_name($new_user_stmt, ":unum", $newnum);
        oci_bind_by_name($new_user_stmt, ":newusr", $_SESSION["newusername"]);
        oci_bind_by_name($new_user_stmt, ":uhash", $_SESSION["newupasshash"]);
        oci_bind_by_name($new_user_stmt, ":upublic", $_SESSION["newprofileavail"]);
        oci_bind_by_name($new_user_stmt, ":usrnpub", $_SESSION["newusrnmvis"]);
        oci_bind_by_name($new_user_stmt, ":edad", $_SESSION["newusr-age"]);
        oci_bind_by_name($new_user_stmt, ":fnym", $_SESSION["newusrfname"]);
  
        oci_execute($new_user_stmt, OCI_DEFAULT);
        oci_commit($connobj);

        /*
        ?>
        <p>Please click the button to check if your information has been added to the database.</p>

        <form method="post" action="new-user.php" class="flexform">
        <fieldset>
            <legend>Check:</legend>
            <div>
                <input type="submit" value="Submit" />
            </div>
        </fieldset>

        </form>

        <?php
        */

        ?>
        <p>If you see no error messages, then your profile has been added to the database!
            You are now an official user!
        </p>


        <?php
        oci_free_statement($new_user_stmt);
        oci_close($connobj);

        $_SESSION["state"] = "oraclesuccess";
    }   // end of second elseif
    elseif($_SESSION["state"] == "oraclesuccess"){
        ?>
        <p>Congrats! Your information has been added to the database, and you are now an offical user!</p>

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
