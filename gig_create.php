<?php
require_once('header.php');
$sql = "SELECT id, name 
        FROM categories 
        ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$sql2 = "SELECT id, name 
         FROM users 
         ORDER BY id ASC";
$result2 = mysqli_query($conn, $sql2);
?>

<div class="main">
<h1> Create Gig </h1>
<div class="container">
    <form action="#" method="POST">
        <div class="row">
            <div class="col-25">
                <label for="title"> Title: </label>
            </div>
            <div class="col-75">
                <input type="text" id="title" name="title" placeholder="Title.." required>
                <br>
                <span class="error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="desc"> Details: </label>
            </div>
            <div class="col-75">
                <textarea name="desc" id="desc" required></textarea>
                <br>
                <span class="error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="cat"> Category: </label>
            </div>
            <div class="col-75">
                <select name="cat">
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
                <br>
                <span class="error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="price"> Price: </label>
            </div>
            <div class="col-75">
                <input type="range" id="price" name="price" min="5" max="1000" oninput="this.nextElementSibling.value = '$'+this.value" required>
                <output style="float: right;">$503</output>
                <br>
                <span class="error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="user"> Seller: </label>
            </div>
            <div class="col-75">
                <select name="user">
                    <?php
                    if (mysqli_num_rows($result2) > 0) 
                    {
                        while ($row2 = mysqli_fetch_assoc($result2)) 
                        {
                            echo "<option value=" . $row2['id'] . ">" . $row2['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <br>
                <span class="error"></span>
            </div>
        </div>
        <br>
        <div class="row">
            <input type="submit" name="submit" id="submit" value="Create">
        </div>
    </form>
</div>
</div>

<?php
if (isset($_POST['submit'])) 
{
    $title = $_POST['title'];
    $desc  = $_POST['desc'];
    $price = $_POST['price'];
    $cat   = $_POST['cat'];
    $user  = $_POST['user'];
    $sql   = "INSERT INTO gigs (title, description, category_id, price, user_id) 
              values('$title', '$desc', $cat, $price, $user)";
    if (mysqli_query($conn, $sql)) 
    {
        header("Location: gigs.php");
    } 
    else 
    {
        echo "<h2>".mysqli_error($conn)."</h2>";
    }
}

require_once('footer.php');
?>