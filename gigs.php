<?php
require_once('header.php');
$sql = "SELECT g.id, g.title, g.category_id, g.price, u.name, c.name as cat
        FROM gigs g, users u, categories c
        WHERE u.id=g.user_id AND c.id=g.category_id
        ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="main">
<br>
<a class="create" href="gig_create.php"> Create New Gig </a>
<h2 style="text-align: center;"> All Gigs </h2>
<table style="margin: auto;">
<tr>
    <th> ID </th>
    <th> Title </th>
    <th> Category </th>
    <th> Price </th>
    <th> Seller </th>
    <th> Operations </th>
</tr>

<?php
if (mysqli_num_rows($result) > 0) 
{
    while ($row = mysqli_fetch_assoc($result)) 
    {
        echo "<tr>";
        echo "<td>" . $row['id'] .
             "</td><td>" . $row['title'] .
             "</td><td>" . $row['cat'] .
             "</td><td>" . $row['price'] .
             "</td><td>" . $row['name'] . "</td>";
        echo "<td><a class='view' href='gig_view.php?id=" . $row['id'] . "'> View </a>
                  <a class='edit' href='gig_update.php?id=" . $row['id'] . "'> Update </a>
                  <a class='delete' href='gig_delete.php?id=" . $row['id'] . "'> Delete </a>
              </td>";
        echo "</tr>";
    }
}
?>

</table>
<br>
</div>

<?php
require_once('footer.php');
?>