<?php
require_once('header.php');
if (isset($_GET['id'])) 
{
    $id = $_GET['id'];
    $sql = "SELECT id, name 
            FROM categories 
            ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    $sql2 = "SELECT id, name 
             FROM users 
             ORDER BY id ASC";
    $result2 = mysqli_query($conn, $sql2);
    $sql3 = "SELECT g.title, g.id, g.description, g.price, g.category_id, g.user_id 
             FROM gigs g 
             WHERE id=$id";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
?>

<div class="main">
    <h1> Update Gig </h1>
    <div class="container">
        <form action="#" method="POST">
            <input type="hidden" name="id" value=<?= $row3['id'] ?>>
            <div class="row">
                <div class="col-25">
                    <label for="title"> Title: </label>
                </div>
                <div class="col-75">
                    <input type="text" id="title" name="title" value="<?= $row3['title'] ?>" required>
                    <br>
                    <span class="error"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="desc"> Details: </label>
                </div>
                <div class="col-75">
                    <textarea name="desc" id="desc" required><?= $row3['description'] ?></textarea>
                    <br>
                    <span class="error"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="price"> Price: </label>
                </div>
                <div class="col-75">
                    <input type="range" id="price" name="price" min="5" max="1000" value="<?= $row3['price'] ?>" oninput="this.nextElementSibling.value = '$'+this.value" required>
                    <output style="float: right;"><?= "$" . $row3['price'] ?></output>
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
                                if ($row3['category_id'] == $row['id']) 
                                {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                }
                            }
                        }
                        $result4 = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result4) > 0) 
                        {
                            while ($row = mysqli_fetch_assoc($result4)) 
                            {
                                if ($row3['category_id'] != $row['id']) 
                                {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <span class="error"></span>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <input type="submit" name="submit" id="submit" value="Update">
        </div>
    </form>
</div>
</div>

<?php
if (isset($_POST['submit'])) 
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $cat = $_POST['cat'];
    $sql = "UPDATE gigs 
            SET title ='$title', description = '$desc', category_id =  $cat, price = $price 
            WHERE id = $id";
    if (mysqli_query($conn, $sql)) 
    {
        header("Location: gigs.php");
    } 
    else 
    {
        echo "<h2>" . mysqli_error($conn) . "</h2>";
    }
}
} 
else 
{
    header("Location: gigs.php");
}
require_once('footer.php');
?>