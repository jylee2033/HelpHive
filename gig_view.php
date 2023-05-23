<?php
require_once('header.php');
?>

<br>

<div class="main">
    
    <?php
    if (isset($_GET['id'])) 
    {
        $id = $_GET['id'];
        $sql = "SELECT g.id, title, description, price, u.name as user, c.name as cat 
                FROM users u, gigs g, categories c 
                WHERE u.id = g.user_id AND g.category_id = c.id AND g.id = $id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result)) 
            {
                echo "<h1>"               . $row['title']         . "</h1>";
                echo "<p>"                . $row['description']   . "</p>" ;
                echo "<h3> Price : $"     . $row['price']         . "</h3>";
                echo "<h3> Seller : "     . $row['user']          . "</h3>";
                echo "<h3> Category : "   . $row['cat']           . "</h3>";
            }
        } 
        else 
        {
            echo "<h2>0 results </h2>";
        }
    }
    else
    {
        header("Location: gigs.php");
    }
    ?>
    
</div>

<?php
require_once('footer.php');
?>