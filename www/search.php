<!DOCTYPE html>
<html>
<head>
<title>Search</title>
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
    <h1>Search<h1>
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
<h2>Search for actor or movie</h2>

<form action="./search.php" id="search_form" method="post">
    <label>Name: </label>
    <input type="text" name="name"><br><br>
    <input type="submit">
</form><br><br>

<?php
    if (!isset($_POST["name"])){
        exit("");
    }
    $name = $_POST["name"];
    if ($name == "") {
        exit("Please enter name");
    }

    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);
    
    $name_list = explode(" ", $name);
    $search_actor = "SELECT * FROM Actor WHERE TRUE";
    $search_movie = "SELECT * FROM Movie WHERE TRUE";
    foreach($name_list as $n) {
        $to_appenda = " AND (first LIKE '%$n%' OR last LIKE '%$n%')";
        $search_actor .= $to_appenda;
        $to_appendm = " AND title LIKE '%$n%'";
        $search_movie .= $to_appendm;
    }
    $search_actor .= " ORDER BY first";
    $search_movie .= " ORDER BY title";

    $actors = mysql_query($search_actor);
    echo "<h3>Matched Actors: <h3>"; 
    if (mysql_num_rows($actors) == 0) {
        echo "No matched actor found<br><br>";
    } else {
        echo "<table border=\"1\">";
        echo "<tr><th>id</th><th>name</th><th>dob</th><th>dod</th></tr>";
        while ($actor = mysql_fetch_row($actors)){
            echo"<tr><td><a href=\"./b1.php?aid=$actor[0]\">$actor[0]<a></td><td><a href=\"./b1.php?aid=$actor[0]\">$actor[2] $actor[1]<a></td><td>$actor[4]</td><td>$actor[5]</td></tr>";
        }
        echo "</table><br><br>";
    }
    

    $movies = mysql_query($search_movie);
    echo "<h3>Matched Movies: <h3>"; 
    if (mysql_num_rows($movies) == 0) {
        echo "No matched movie found<br><br>";
    } else {
        echo "<table border=\"1\">";
        echo "<tr><th>id</th><th>title</th><th>year</th></tr>";
        while ($movie = mysql_fetch_row($movies)){
            echo"<tr><td><a href=\"./b2.php?mid=$movie[0]\">$movie[0]<a></td><td><a href=\"./b2.php?mid=$movie[0]\">$movie[1]<a></td><td>$movie[2]</td></tr>";
        }
        echo "</table><br><br>";
    }

    mysql_close($db_connection);
?>

</body>
</html>