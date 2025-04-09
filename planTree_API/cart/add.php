<?php

//add produt into cart table

include '../connection.php';

$user_id=$_POST['user_id'];
$item_id=$_POST['item_id'];
$quantity=$_POST['quantity'];

$sqlQuery="INSERT INTO cart_table SET user_id='$user_id' , item_id='$item_id' , quantity='$quantity'";

$resultOfQuery=mysqli_query($con,$sqlQuery);

if($resultOfQuery)
{
    echo json_encode(array("success"=>true));
}
else
{
    echo json_encode(array("success"=>false));
}