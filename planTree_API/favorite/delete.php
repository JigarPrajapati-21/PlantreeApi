<?php

include '../connection.php';


$user_id=$_POST['user_id'];
$item_id=$_POST['item_id'];

$sqlQuery="DELETE FROM favorite_table WHERE user_id='$user_id' AND item_id='$item_id' ";

$resultOfQuery=mysqli_query($con,$sqlQuery);

if($resultOfQuery->num_rows>0)
{
    echo json_encode(array("success"=>true));
}
else
{
    echo json_encode(array("success"=>false));
}