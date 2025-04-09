<?php

//delete produt from cart table

include '../connection.php';


$cartID=$_POST['cart_id'];

$sqlQuery="DELETE FROM cart_table WHERE cart_id='$cartID' ";

$resultOfQuery=mysqli_query($con,$sqlQuery);

if($resultOfQuery)
{
    echo json_encode(array("success"=>true));
}
else
{
    echo json_encode(array("success"=>false));
}