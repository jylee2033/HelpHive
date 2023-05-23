<?php
require_once('header.php');
$sql = "SELECT id, title 
         FROM gigs 
         ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$sql2 = "SELECT description 
         FROM order_status 
         ORDER BY id ASC";
$result2 = mysqli_query($conn, $sql2);
?>

<div class="main">
<h3> Get number of orders of a selected gig based on current status (NESTED) </h3>
<form action="" method="GET">
    <div class="row">
        <div class="col-25">
            <label for="id"> Select Gig: </label>
        </div>
        <div class="col-75">
            <select name="id">
                <?php
                if (mysqli_num_rows($result) > 0) 
                {
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        echo "<option value=" . $row['id'] . ">" . $row['title'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-25">
            <label for="status"> Current Status: </label>
        </div>
        <div class="col-75">
            <select name="status">
                <?php
                if (mysqli_num_rows($result2) > 0) 
                {
                    while ($row2 = mysqli_fetch_assoc($result2)) 
                    {
                        echo "<option value='" . $row2['description'] . "'>" . $row2['description'] . "</option>";
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
    $id = $_GET['id'];
    $status = $_GET['status'];
    $sql = "SELECT g.id, g.title, count(o.id) as completed 
            FROM gigs g LEFT JOIN orders o ON g.id=o.gig 
            WHERE o.status=(SELECT id 
                            FROM order_status os 
                            WHERE os.description='$status') 
            AND g.id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $rev = 0;
        echo "<table>";
        echo "<tr><th> ID 
              </th><th> Title 
              </th><th> Number of Orders </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"  . $row['id'] . 
                 "</td><td>" . $row['title'] . 
                 "</td><td>" . $row['completed'] . "</td></tr>";
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
<h3> Buyers with an average purchase of more than $450 per buyer (NESTED) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query2" value="Run" />
    </div>
</form>
<br>

<?php
if (isset($_GET['query2'])) 
{
    $sql = "SELECT TEMPs.buyer, TEMPs.avgPrice 
            FROM (SELECT o2.buyer, avg(price) as avgPrice
                  FROM orders O2
                  LEFT JOIN gigs G ON O2.gig=G.id 
                  GROUP by buyer) as TEMPs
            WHERE  TEMPs.avgPrice > 450
            ORDER by TEMPs.buyer";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> Buyer
              </th><th> Average Purchase </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['buyer'] . 
                 "</td><td>$"  . $row['avgPrice'] . "</td></tr>";
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
<h3> Average price by category for gigs with 2 or more orders (NESTED) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query3" value="Run"/>
    </div>
</form>
<br>

<?php
if (isset($_GET['query3'])) 
{
    $sql = "SELECT g.id, g.category_id, AVG(g.Price) as avg_price
            FROM gigs g
            GROUP by g.category_id
            HAVING 2 <= (SELECT count(*) 
                         FROM gigs g2, orders o 
                         WHERE g.id = g2.id 
                         AND g2.id = o.gig)";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> ID
              </th><th> Category_ID
              </th><th> Average Price </th></tr>";
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "<tr><td>"   . $row['id'] . 
                 "</td><td>"  . $row['category_id'] . 
                 "</td><td>$"  . $row['avg_price'] . "</td></tr>";
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
<h3> Get users who purchased all gigs (DIVISION) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query4" value="Run" />
    </div>
</form>
<br>

<?php
if (isset($_GET['query4'])) 
{
    $sql = "SELECT *
            FROM users U
            WHERE NOT EXISTS (SELECT * 
                              FROM gigs G
                              WHERE NOT EXISTS
                             (SELECT *      
                              FROM orders O
                              WHERE O.buyer=U.id AND O.gig=G.id))";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> ID
              </th><th> Name
              </th><th> Email </th></tr>";
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
<h3> Get users who do not have any skills (DIVISION) </h3>
<form action="" method="GET">
    <div class="row">
        <input type="submit" name="query5" value="Run" />
    </div>
</form>
<br>

<?php
if (isset($_GET['query5'])) 
{
    $sql = "SELECT * 
            FROM users 
            WHERE not exists (SELECT * 
                              FROM skills 
                              WHERE skills.id=users.id)";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table>";
        echo "</th><th> ID
              </th><th> Name
              </th><th> Email </th></tr>";
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

<?php
require_once('footer.php');
?>