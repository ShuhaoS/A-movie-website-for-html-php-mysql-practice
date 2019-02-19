<!DOCTYPE html>
<html>
<head>
<title>Add a new Actor or Director</title>
<link rel="stylesheet" href="nav.css"> 
</head>

<body>
<header>
    <h1>Add a new Actor or Director<h1>
</header>


<ul>
    <li><a href="./i1.php">Add a new Actor or Director</a></li>
    <li><a href="./i2.php">Add a new Movie</a></li>
    <li><a href="./i3.php">Add a new Comment</a></li>
    <li><a href="./i4.php">Add a new Actor to a Movie</a></li>
    <li><a href="./i5.php">Add a new Director to a Movie</a></li>
    <li><a href="./search.php">Search</a></li>
    <li><a href="./b1.php">Show an Actor's info</a></li>
    <li><a href="./b2.php">Show a Movie's info</a></li>
    <li><a href="./index.php">Index Page</a></li>
</ul>

<br>
<h2>Adding a new director or actor to the database:</h2>
<form action="./i1.php" id="addad_form" method="post">
    <span>Type: &nbsp; &nbsp;</span>
    <input type="radio" name="who" id="actor" value="actor" checked>
    <label for="actor">Actor</label>&nbsp;
    <input type="radio" name="who" id="director" value="director">
    <label for="director">Director</label><br><br>

    <label>First name: </label>&nbsp;
    <input type="text" name="fname"><br><br>
    <label>Last name: </label>&nbsp;
    <input type="text" name="lname"><br><br>

    <span>Sex: &nbsp; &nbsp;</span>
    <input type="radio" name="sex" value="Female" checked>
    <label>Female</label>&nbsp;
    <input type="radio" name="sex" value="Male">
    <label>Male</label>&nbsp;
    <input type="radio" name="sex" value="Transgender">
    <label>Transgender</label>&nbsp;<br><br>

    <label>Date of Birth: </label>&nbsp;
    <input type="text" name="dob">
    <span>(YYYY-MM-DD)</span><br><br>
    <label>Date of Death: </label>&nbsp;
    <input type="text" name="dod">
    <span>(YYYY-MM-DD)</span><br><br><br>

    <input type="submit">
</form>

<?php
    if (!isset($_POST["who"])){
        exit("");
    }

    $who = $_POST["who"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $dod = $_POST["dod"];

    if ($fname == "") {
        echo "<br>";
        exit("Please Enter first name!");
    }
    if ($lname == "") {
        echo "<br>";
        exit("Please Enter last name!");
    }
    if ($dob == "") {
        echo "<br>";
        exit("Please Enter date of birth!");
    }
    if ($dod == "") {
        $dod = "NULL";
    } else {
        $dod = "'$dod'";
    }

    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);
    
    $get_id = "SELECT * FROM MaxPersonID";
    $result = mysql_query($get_id, $db_connection);
    $row = mysql_fetch_row($result);
    $pid = intval($row[0]);
    $new_pid = $pid + 1;
    
    $update_id = "UPDATE MaxPersonID SET id = $new_pid WHERE id = $pid";
    
    if ($who == "actor") {
        $query = "INSERT INTO Actor VALUES ($new_pid, '$lname', '$fname', '$sex', '$dob', $dod)";
    } else {
        $query = "INSERT INTO Director VALUES ($new_pid, '$lname', '$fname', '$dob', $dod)";
    }
    
    $success = mysql_query($query, $db_connection);
    if ($success) {
        mysql_query($update_id, $db_connection);
        echo "A new $who successfully added with id $new_pid !";
    } else {
        exit("Failed to add the new $who");
    }

    mysql_close($db_connection);
?>
</body>
</html>