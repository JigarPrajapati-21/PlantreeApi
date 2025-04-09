<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, HEAD, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: content-type');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Vary: Origin");


// $con = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
if(!$con)
{
    die("Connection Failed: ".mysqli_connect_error());

}
else
{
    $useremail = $_POST['user_email'];
  // $useremail = "jigar@gmail.com";
  $sel="SELECT * FROM user_table WHERE user_email='".$useremail."'";     
  $result = mysqli_query($con, $sel);
  $user_details = [];
  $count = mysqli_num_rows($result);

  while ($row = mysqli_fetch_assoc($result)) {
   $user_details[] = $row;
   
}
    
    if($count==1)
    {
        //if Email is exist
       // echo json_encode(["status"=>"success","data"=>$user_details[0]]);
       echo json_encode(array(
        "status" => "success",
        "userData" => $user_details[0],
    ));
    }else{
        //if Email is not exist
        echo json_encode(["status"=>"error","message"=>"Email does not exist"]);
    }
}