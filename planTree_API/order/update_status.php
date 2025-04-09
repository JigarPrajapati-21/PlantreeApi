<?php
// $server = "192.168.10.254";
// $username = "GP2431";
// $password = "O57022";
// $dbname = "gp2431_db";

// $con = mysqli_connect($server, $username, $password, $dbname);

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
// echo "1111";
$orderID =  $_POST['order_id'];
// echo"2222";
// echo $orderID;
$sqlQuery = "UPDATE orders_table SET status='received' WHERE order_id ='$orderID'";


// echo $sqlQuery;
// echo"3333333";
$resultOfQuery = mysqli_query($con,$sqlQuery);
// echo"44444";
if($resultOfQuery)
{
    echo json_encode(array("success"=>true));
}
else
{
    echo json_encode(array("success"=>false));
}