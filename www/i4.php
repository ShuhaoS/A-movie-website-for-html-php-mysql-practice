<!DOCTYPE html>
<html>
<head>
<title>Add a new Actor to a Movie</title>
<link rel="stylesheet" href="nav.css"> 
<style>
    label {
    padding-left: 1.5em;
    text-indent: -.7em;
}

</style>
</head>

<body>
<header>
    <h1>Add a new Actor to a Movie<h1>
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
<h2>Adding a new actor-movie relation to database:</h2>

<form action="./i4.php" id="addam_form" method="post">
    <span>Movie to add relation to:</span><br><br>
    <label> MovieID:</label>
    <input type="text" name="mid"><br><br><br>
    <label> If the movie ID is not given, please give the following information:</label><br><br>
    <label>Title:</label>&nbsp;
    <input type="text" name="title">
    <span>(only Required)</span><br><br>
    <label>Year:</label>&nbsp;
    <input type="text" name="year">
    <span>(YYYY)</span><br><br><br>

    <span>Actor to be added to Movie:<span><br><br>
    <label> ActorID:</label>
    <input type="text" name="aid">
    <label> Role:</label>
    <input type="text" name="role"><br><br><br>
    <label> If the actor ID is not given, please give the following information:</label><br><br>
    <label>Full Name: </label>&nbsp;
    <input type="text" name="name">
    <span>(only Required, First Name at first)</span><br><br>
    <label>Sex: </label>
    <input type="radio" name="sex" value="Female" checked>
    <span>Female</span>&nbsp;
    <input type="radio" name="sex" value="Male">
    <span>Male</span>&nbsp;
    <input type="radio" name="sex" value="Transgender">
    <span>Transgender</span>
    <span>(not effective if date of birth not entered)</span><br><br>
    <label>Date of Birth: </label>&nbsp;
    <input type="text" name="dob">
    <span>(YYYY-MM-DD)</span><br><br>
    <input type="submit">
</form>
    
<?php
    if (!isset($_POST["mid"])){
        exit("");
    }
    $mid = $_POST["mid"];
    $title = $_POST["title"];
    $year = $_POST["year"];
    $aid = $_POST["aid"];
    $name = $_POST["name"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $role = $_POST["role"];

    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    if ($mid == "") {
        if ($title == "") {
            exit("Please enter movie id or movie title.");
        }
        $get_mid = "SELECT id FROM Movie WHERE title = '$title'";
        $mid_db = mysql_query($get_mid, $db_connection);
        $num_rows = mysql_num_rows($mid_db);
        if ($num_rows == 0) {
            exit("Fail to find movie with title '$title'");
        } elseif ($num_rows == 1) {
            $mid = mysql_fetch_row($mid_db)[0];
        } else {
            if ($year == "") {
                exit("There are more than 1 movie with title '$title'. Please enter year.");
            }
            $get_mid = "SELECT id FROM Movie WHERE title = '$title' AND year = $year";
            $mid_db = mysql_query($get_mid, $db_connection);
            $num_rows = mysql_num_rows($mid_db);
            if ($num_rows == 0) {
                exit("Fail to find movie with title '$title' and year $year");
            } elseif ($num_rows == 1) {
                $mid = mysql_fetch_row($mid_db)[0];
            } else {
                exit("There are more than 1 movie with '$title' and year $year. Please use movie id.");
            }
        }
    }
    if ($aid == "") {
        if ($name == "") {
            exit("Please enter actor id or actor name");
        }
        $name_split = explode(" ", $name);
        if (sizeof($name_split) != 2) {
            exit("Please enter a full name including first name and last name.");
        }
        $first_name = $name_split[0];
        $last_name = $name_split[1];
        $get_aid = "SELECT id FROM Actor WHERE first = '$first_name' AND last = '$last_name'";
        $aid_db = mysql_query($get_aid, $db_connection);
        $num_rows = mysql_num_rows($aid_db);
        if ($num_rows == 0) {
            exit("Fail to find actor with name $name");
        } elseif ($num_rows == 1) {
            $aid = mysql_fetch_row($aid_db)[0];
        } else {
            if ($dob == "") {
                exit("There are more than 1 actor with name $name. Please enter sex and date of birth.");
            }
            $get_aid = "SELECT id FROM Actor WHERE first = '$first_name' AND last = '$last_name' AND sex = '$sex' AND dob = '$dob'";
            $aid_db = mysql_query($get_aid,$db_connection);
            $num_rows = mysql_num_rows($aid_db);
            if ($num_rows == 0) {
                exit("Fail to find actor with name $name, gender $sex and date of birth $dob");
            } elseif ($num_rows == 1) {
                $aid = mysql_fetch_row($aid_db)[0];
            } else {
                exit("There are more than 1 actor with name $name, gender $sex and date of birth $dob. Please provide actor id.");
            }
        }
    }
    if ($role == "") {
        exit("Please enter role");
    }
    $query = "INSERT INTO MovieActor VALUES($mid, $aid, '$role')";
    $success = mysql_query($query, $db_connection);
    if ($success) {
        echo "A new movie-actor relation with mid $mid, aid $aid and role $role is added to the database successfully!<br>";
    } else {
        exit("Fail to add new movie-actor relation with mid $mid, aid $aid and role $role");
    }

    mysql_close($db_connection);
?>
</body>
</html>