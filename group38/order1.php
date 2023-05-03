<?php
require_once('header.php');
$sql     = "SELECT id, name 
            FROM users";
$result  = mysqli_query($conn, $sql);
$sql2    = "SELECT id, description 
           FROM order_status";
$result2 = mysqli_query($conn, $sql2);
$sql3 = "SELECT id, title 
        FROM gigs 
        ORDER BY id ASC";
$result3 = mysqli_query($conn, $sql3);
$sql4 = "SELECT id, title 
         FROM gigs 
         ORDER BY id ASC";
$result4 = mysqli_query($conn, $sql4);
?>

<div class="main">
<h3> Get buyers based on the seller and order status (JOIN) </h3>
<form action="" method="GET">
    <div class="row">
        <div class="col-25">
            <label for="seller"> Select Seller: </label>
        </div>
        <div class="col-75">
            <select name="seller">
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
    <div class="row">
        <div class="col-25">
            <label for="status"> Select Status: </label>
        </div>
        <div class="col-75">
            <select name="status">
                <?php
                if (mysqli_num_rows($result2) > 0) 
                {
                    while ($row2 = mysqli_fetch_assoc($result2)) 
                    {
                        echo "<option value=" . $row2['id'] . ">" . $row2['description'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <input type="submit" name="query1" value="Run" />
    </div>
</form>
<br>

<?php
if (isset($_GET['query1'])) 
{
    $seller = $_GET['seller'];
    $status = $_GET['status'];
    $sql = "SELECT o.id, u.name as buyer, g.title as gig, s.description as status 
            FROM order_status s 
            JOIN orders o ON s.id=o.status
            JOIN gigs g ON o.gig=g.id
            JOIN users u ON u.id=o.buyer
            WHERE g.user_id=$seller AND s.id=$status
            ORDER BY o.id ASC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "<tr><th> Buyer
              </th><th> Gig 
              </th><th> Status </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"  . $row['buyer'] . 
                 "</td><td>" . $row['gig'] . 
                 "</td><td>" . $row['status'] . "</td></tr>";
        }
        echo "</table>";
    } 
    else 
    {
        echo "<h2>0 results</h2>";
    }
}
?>
</div>
<br>

<div class="main">
<h3> Get sellers and their first skill (JOIN) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query2" value="Run" />
    </div>
</form>
<br>

<?php
if (isset($_GET['query2'])) 
{
    $sql = "SELECT * 
            FROM users u, skills s 
            WHERE u.skill_1 = s.id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> Name
              </th><th> Email 
              </th><th> 1st Skill </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['name'] . 
                 "</td><td>"  . $row['email'] . 
                 "</td><td>"  . $row['skill'] . "</td></tr>";
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
<h3> Get total orders and revenue of a selected gig (AGGREGATION) </h3>
<form action="" method="GET">
    <div class="row">
        <div class="col-25">
            <label for="id"> Select Gig: </label>
        </div>
        <div class="col-75">
            <select name="id">
                <?php
                if (mysqli_num_rows($result3) > 0) 
                {
                    while ($row3 = mysqli_fetch_assoc($result3)) 
                    {
                        echo "<option value=" . $row3['id'] . ">" . $row3['title'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <input type="submit" name="query3" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query3'])) 
{
    $id = $_GET['id'];
    $sql = "SELECT g.id, g.title, g.price, COUNT(o.gig) as order_count, SUM(g.price) as revenue
            FROM gigs g 
            JOIN orders o ON g.id=o.gig
            WHERE g.id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $rev = 0;
        echo "<table>";
        echo "<tr><th> ID 
              </th><th> Title
              </th><th> Price 
              </th><th> Total Orders
              </th><th> Revenue </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            if ($row['revenue']) 
            {
                $rev = $row['revenue'];
            }
            echo "<tr><td>"   . $row['id'] . 
                 "</td><td>"  . $row['title'] . 
                 "</td><td>$" . $row['price'] . 
                 "</td><td>"  . $row['order_count'] . 
                 "</td><td>$" . $rev . "</td></tr>";
        }
        echo "</table>";
    } 
    else
    {
        echo "<h2>0 results</h2>";
    }
}
?>
</div>
<br>

<div class="main">
<h3> Get users and their total orders of a selected gig (AGGREGATION) </h3>
<form action="" method="GET">
    <div class="row">
        <div class="col-25">
            <label for="id"> Select Gig: </label>
        </div>
        <div class="col-75">
            <select name="id">
                <?php
                if (mysqli_num_rows($result4) > 0) 
                {
                    while ($row4 = mysqli_fetch_assoc($result4)) 
                    {
                        echo "<option value=" . $row4['id'] . ">" . $row4['title'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <input type="submit" name="query4" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query4'])) 
{
    $id = $_GET['id'];
    $sql = "SELECT DISTINCT u.id, u.name, u.email, g.title, COUNT(o.id) as total_count 
            FROM users u
            INNER JOIN orders o ON u.id=o.buyer
            INNER JOIN gigs g ON o.gig=g.id 
            WHERE g.id=$id
            GROUP BY u.id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "<tr><th> ID 
              </th><th> Name 
              </th><th> Email 
              </th><th> Gig 
              </th><th> Total Orders </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"  . $row['id'] . 
                 "</td><td>" . $row['name'] . 
                 "</td><td>" . $row['email'] . 
                 "</td><td>" . $row['title'] . 
                 "</td><td>" . $row['total_count'] . "</td></tr>";
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