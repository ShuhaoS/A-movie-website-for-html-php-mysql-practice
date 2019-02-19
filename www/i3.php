<!DOCTYPE html>
<html>
<head>
<title>Add new Comments</title>
<link rel="stylesheet" href="nav.css"> 
</head>

<body>
<header>
    <h1>Add new Comments<h1>
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
<h2>Adding a new comment to database:</h2>

<form action="./i3.php" id="addc_form" method="post">
    <label>Username: </label>
    <input type="text" name="username"><br><br>
    <label>Movie: </label>
    <select name="mid">
        <?php
            $db_connection = mysql_connect("localhost", "cs143", "");
            mysql_select_db("CS143", $db_connection);
            $get_movie_titles = "SELECT title, year, id FROM Movie ORDER BY title";
            $movie_titles = mysql_query($get_movie_titles, $db_connection);
            while ($row = mysql_fetch_row($movie_titles)){
                $op = $row[0];
                $year = $row[1];
                $mid = $row[2];
                echo "<option value=\"$mid\">$op ($year)</option>";
            }
            mysql_close($db_connection);
        ?>
    </select><br><br>
    <label>Rating: </label>
    <select name="rating">
        <option value="5">5 stars</option>
        <option value="4">4 stars</option>
        <option value="3">3 stars</option>
        <option value="2">2 stars</option>
        <option value="1">1 star</option>
    </select><br><br>
    <label>Comment: </label><br>
    <textarea rows="10" cols="50" name="comment"></textarea><br><br>
    <input type="submit">
</form>

<?php
    if (!isset($_POST["username"])){
        exit("");
    }
    $mid = $_POST["mid"];
    $username = $_POST["username"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    if (strlen($comment) > 500) {
        exit("Comment too long. Comment length should be at most 500.");
    }
    if($username == "") {
        $username = "NULL";
    } else {
        $username = "'$username'";
    }
    
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);
    $add_comment = "INSERT INTO Review VALUES($username, NOW(), $mid, $rating, '$comment')";
    $success = mysql_query($add_comment, $db_connection);
    if ($success) {
        echo "Successfully add the new comment!";
    } else {
        exit("Fail to add comment");
    }

    mysql_close($db_connection);
?>
</body>
</html>