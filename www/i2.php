<!DOCTYPE html>
<html>
<head>
<title>Add a new Movie</title>
<link rel="stylesheet" href="nav.css"> 
</head>

<body>
<header>
    <h1>Add a new Movie<h1>
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
<h2>Adding a new movie to the database:</h2>
<form action="./i2.php" id="addm_form" method="post">
    <label>Title:</label>&nbsp;
    <input type="text" name="title"><br><br>
    <label>Year:</label>&nbsp;
    <input type="text" name="year">
    <span>(YYYY)</span><br><br>
    <label>Director:</label>&nbsp;
    <input type="text" name="director"><br><br>
    <label>MPAA Rating:</label>&nbsp;
    <select name="rating">
        <option value="G">G</option>
        <option value="PG">PG</option>
        <option value="PG-13">PG-13</option>
        <option value="NC-17">NC-17</option>
        <option value="R">R</option>
        <option value="surrendere">surrendere</option>
    </select><br><br>
    <label>Company:</label>&nbsp;
    <input type="text" name="company"><br><br>
    <label>Genre:</label><br>
        <input type="checkbox" name="genre[]" value="Drama">Drama
        <input type="checkbox" name="genre[]" value="Comedy">Comedy
        <input type="checkbox" name="genre[]" value="Romance">Romance
        <input type="checkbox" name="genre[]" value="Crime">Crime
        <input type="checkbox" name="genre[]" value="Horror">Horror
        <input type="checkbox" name="genre[]" value="Mystery">Mystery
        <input type="checkbox" name="genre[]" value="Thriller">Thriller
        <input type="checkbox" name="genre[]" value="Action">Action
        <input type="checkbox" name="genre[]" value="Adventure">Adventure
        <input type="checkbox" name="genre[]" value="Fantasy">Fantasy
        <input type="checkbox" name="genre[]" value="Documentary">Documentary
        <input type="checkbox" name="genre[]" value="Family">Family
        <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi
        <input type="checkbox" name="genre[]"option value="Animation">Animation
        <input type="checkbox" name="genre[]" value="Musical">Musical
        <input type="checkbox" name="genre[]" value="War">War
        <input type="checkbox" name="genre[]" value="Western">Western
        <input type="checkbox" name="genre[]" value="Adult">Adult
        <input type="checkbox" name="genre[]" value="Short">Short
    <br><br>
    <label>Role:</label><br>
    &nbsp;&nbsp;<label>Actor name:</label>&nbsp;
    <input type="text" name="actor"><br><br>
    &nbsp;&nbsp;<label>Role &nbsp; name:</label>&nbsp;
    <input type="text" name="role"><br><br><br>
    <input type="submit">
</form>
<?php
    if (!isset($_POST["title"])){
        exit("");
    }
    $title = $_POST["title"];
    $year = $_POST["year"];
    $director = $_POST["director"];
    $rating = $_POST["rating"];
    $company = $_POST["company"];
    $genre = $_POST["genre"];
    $actor = $_POST["actor"];
    $role = $_POST["role"];

    if ($title == "") {
        echo "<br>";
        exit("Please Enter Title!");
    }
    if ($year == "") {
        echo "<br>";
        exit("Please Enter Year!");
    }
    if ($company == "") {
        echo "<br>";
        exit("Please Enter Company!");
    }


    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);
    
    $get_mid = "SELECT * FROM MaxMovieID";
    $mid_db = mysql_query($get_mid, $db_connection);
    $mid_row = mysql_fetch_row($mid_db);
    $mid = intval($mid_row[0]);
    $new_mid = $mid + 1;
    

    $update_id = "UPDATE MaxMovieID SET id = $new_mid WHERE id = $mid";
    $insert_movie = "INSERT INTO Movie VALUES ($new_mid, '$title', $year, '$rating','$company')";
    $success = mysql_query($insert_movie, $db_connection);
    if ($success) {
        mysql_query($update_id, $db_connection);
        echo "A new movie successfully added with id $new_mid !<br>";
    } else {
        exit("Failed to add the new movie");
    }

    $n = count($genre);
    for ($i=0; $i < $n; $i++) {
        $insert_genre = "INSERT INTO MovieGenre VALUES ($new_mid, '$genre[$i]')";
        $success = mysql_query($insert_genre, $db_connection);
        if (!$success) {
            exit("Failed to insert movie genre $genre[$i]");
        }

    }
    echo "All genre of new movie added!<br>";

    
    if ($director != "") {
        $d_name = explode(" ", $director);
        $get_did = "SELECT id FROM Director WHERE first = '$d_name[0]'and last = '$d_name[1]'";
        $dids = mysql_query($get_did, $db_connection);
        if (mysql_num_rows($dids) == 0) {
            echo "Director $director not found<br>";
        } elseif (mysql_num_rows($dids) > 1) {
            echo "More than one director with name $director found.<br>";
        } else {
            $did = mysql_fetch_row($dids)[0];
            $success = mysql_query("INSERT INTO MovieDirector VALUES($new_mid, $did)",$db_connection);
            if ($success) {
                echo "Successfully add the movie-director relation<br>";
            } else {
                echo "Fail to add the movie-director relation<br>";
            }
        }
    }
    if ($actor != "" && $role != "") {
        $a_name = explode(" ", $actor);
        $get_aid = "SELECT id FROM Actor WHERE first = '$a_name[0]'and last = '$a_name[1]'";
        $aids = mysql_query($get_aid, $db_connection);
        if (mysql_num_rows($aids) == 0) {
            echo "Actor $actor not found<br>";
        } elseif (mysql_num_rows($aids) > 1) {
            echo "More than one actor with name $director found.<br>";
        } else {
            $aid = mysql_fetch_row($aids)[0];
            $success = mysql_query("INSERT INTO MovieActor VALUES($new_mid, $aid, '$role')",$db_connection);
            if ($success) {
                echo "Successfully add the movie-actor relation<br>";
            } else {
                echo "Fail to add the movie-actor relation<br>";
            }
        }
    }
    mysql_close($db_connection);
?>

</body>
</html>