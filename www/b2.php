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
    <h1>Show info about the movie<h1>
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
<h2>Movie Information</h2>
<br><br>

<?php
    if (!isset($_GET["mid"])){
        exit("");
    }
    $mid = $_GET["mid"];
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);
    $get_minfo = "SELECT * FROM Movie WHERE id = $mid";
    $minfo = mysql_query($get_minfo, $db_connection);
    $minfo_list = mysql_fetch_row($minfo);
    echo "Title: $minfo_list[1]<br>";
    echo "Year: $minfo_list[2]<br>";
    echo "Company: $minfo_list[4]<br>";
    echo "Rating: $minfo_list[3]<br>";
    
    $get_d = "SELECT did FROM MovieDirector WHERE mid = $mid";
    $directors = mysql_query($get_d, $db_connection);
    if (mysql_num_rows($directors) == 0) {
        echo "Director: not recorded in datatbase";
    } else {
        while($director = mysql_fetch_row($directors)) {
            $did = $director[0];
            $director_name_split = mysql_fetch_row(mysql_query("SELECT first, last from Director WHERE id = $did",$db_connection));
            $director_name = $director_name_split[0]." ".$director_name_split[1];
            echo "Director: $director_name";
        }
    }
    echo "<br>";

    $get_g = "SELECT genre FROM MovieGenre WHERE mid = $mid";
    $genres = mysql_query($get_g, $db_connection);
    while($genre = mysql_fetch_row($genres)) {
        echo "Genre: $genre[0]&nbsp&nbsp";
    }
    echo "<br><br><br>";

    $get_a = "SELECT * FROM MovieActor WHERE mid = $mid";
    $actors = mysql_query($get_a, $db_connection);
    if (mysql_num_rows($actors) == 0)
    {
        echo "<h2>No Actor Found</h2><br><br>";
    } else {
        echo "<h2>Actors in this Movie</h2><br><br>";
        echo "<table border=\"1\">";
        echo "<tr><th>id</th><th>name</th><th>role</th></tr>";
        while ($actor = mysql_fetch_row($actors)) {
            $aid = $actor[1];
            $role = $actor[2];
            $actor_info = mysql_fetch_row(mysql_query("SELECT first, last FROM Actor WHERE id=$aid",$db_connection));
            $actor_name = $actor_info[0]." ".$actor_info[1];
            echo "<tr><td><a href=\"./b1.php?aid=$aid\">$aid<a></td><td><a href=\"./b1.php?aid=$aid\">$actor_name<a></td><td>$role</td></tr>";
        }
        echo "</table><br><br><br>";
    }

    $get_review = "SELECT * FROM Review WHERE mid = $mid";
    $reviews = mysql_query($get_review, $db_connection);
    if (mysql_num_rows($reviews) == 0)
    {
        echo "<h2>No Review Found</h2><br><br>";
    } else {
        echo "<h2>User Review:</h2><br><br>";
        $avg_score = mysql_fetch_row(mysql_query("SELECT avg(rating) FROM Review WHERE mid = $mid", $db_connection))[0];
        $num_reviews = mysql_num_rows($reviews);
        echo "Average score for this Movie is $avg_score based on $num_reviews reviews";
        echo "<br><br>";
        echo "<table border=\"1\">";
        echo "<tr><th>name</th><th>time</th><th>rating</th><th>comment</th></tr>";
        while ($review = mysql_fetch_row($reviews)) {
            echo "<tr><td>$review[0]</td><td>$review[1]</td><td>$review[3]</td><td>$review[4]</th></tr>";
        }
        echo "</table><br><br>";
    }
    echo "<a href=\"./i3.php\">Leave your review as well</a><br>";
    
?>


</body>
</html>