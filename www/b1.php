<!DOCTYPE html>
<html>
<head>
<title>Show info about the movie</title>
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
    <h1>Show info about the actor<h1>
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
<h2>Actor Information</h2>
<br><br>

<?php
    if (!isset($_GET["aid"])){
        exit("");
    }
    $aid = $_GET["aid"];
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    $get_actor_info = "SELECT * FROM Actor WHERE id = $aid";
    $actor_info = mysql_fetch_row(mysql_query($get_actor_info, $db_connection));
    echo "Name: $actor_info[2] $actor_info[1]<br>";
    echo "Gender: $actor_info[3]<br>";
    echo "Date of Birth: $actor_info[4]<br>";
    echo "Date of Death: $actor_info[5]<br>";
    echo "<br><br>";
    
    echo "<h2>Movies the actor was in</h2><br><br>";
    $get_movies = "SELECT m.id, m.title, ma.role FROM MovieActor ma, Movie m WHERE ma.aid = $aid AND ma.mid = m.id";
    $movies = mysql_query($get_movies, $db_connection);
    if (mysql_num_rows($movies) == 0) {
        echo "No movie of the this actor is recorded in the database.<br>";
        exit("");
    }
    echo "<table border=\"1\">";
    echo "<tr><th>id</th><th>title</th><th>role</th></tr>";
    while ($movie = mysql_fetch_row($movies)) {
        echo "<tr><td><a href=\"./b2.php?mid=$movie[0]\">$movie[0]</td><td><a href=\"./b2.php?mid=$movie[0]\">$movie[1]<a></td><td>$movie[2]</td></tr>";
    }
    echo "</table><br>";
?>
</body>
</html>