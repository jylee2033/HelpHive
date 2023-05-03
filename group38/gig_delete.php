<?php
require('header.php');
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM gigs 
            WHERE id=$id";
    if(mysqli_query($conn, $sql))
    {
        header("Location: gigs.php");
    }
    else
    {
        echo mysqli_error($conn);
    }
}
else
{
    header("Location: gigs.php");
}
?>