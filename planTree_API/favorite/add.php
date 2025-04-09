<?php

include '../connection.php';

$user_id=$_POST['user_id'];
$item_id=$_POST['item_id'];

$selQuery="INSERT INTO favorite_table SET user_id='$user_id' , item_id='$item_id'";

$resultOfQuery=mysqli_query($con,$selQuery);

if($resultOfQuery->num_rows>0)
{
    echo json_encode(array("success"=>true));
}
else
{
    echo json_encode(array("success"=>false));
}