<?php
require_once('header.php');
$sql    = "SELECT id, name 
            FROM users 
            ORDER BY id ASC";
$result =  mysqli_query($conn, $sql);
?>

<div class="main">
<h3> Get all gigs created by selected users (SELECTION) </h3>
<form action="" method="GET">
    <div class="row">
        <div class="col-25">
            <label for="id"> Select Name: </label>
        </div>
        <div class="col-75">
            <select name="id">
                <?php
                if (mysqli_num_rows($result) > 0) 
                {
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <input type="submit" name="query1" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query1'])) 
{
    $id = $_GET['id'];
    $sql = "SELECT title, description, price 
            FROM gigs INNER JOIN users on gigs.user_id=users.id 
            WHERE users.id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> Title
              </th><th> Details
              </th><th> Price";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['title'] . 
                 "</td><td>"  . $row['description'] . 
                 "</td><td>$" . $row['price'] . "</td></tr>";
        }
        echo "</table>";
    } 
    else 
    {
        echo "<h2>0 results </h2>";
    }
}
?>
</div>
<br>

<div class="main">
<h3> Get ID, Name, Email from users TABLE (PROJECTION) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query2" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query2'])) 
{
    $sql = "SELECT id, name, email
            FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> ID
              </th><th> Name
              </th><th> Email";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['id'] . 
                 "</td><td>"  . $row['name'] . 
                 "</td><td>"  . $row['email'] . "</td></tr>";
        }
        echo "</table>";
    } 
    else 
    {
        echo "<h2>0 results </h2>";
    }
}
?>
</div>
<br>

<div class="main">
<h3> Get BuyerID, GigID from orders TABLE (PROJECTION) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query3" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query3'])) 
{
    $sql = "SELECT buyer, gig
            FROM orders";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> BuyerID
              </th><th> GigID";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['buyer'] . 
                 "</td><td>"  . $row['gig'] . "</td></tr>";
        }
        echo "</table>";
    } 
    else 
    {
        echo "<h2>0 results </h2>";
    }
}
?>
</div>

<?php
require_once('footer.php');
?>