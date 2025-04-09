
<?php

//  $con = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");
// $con = mysqli_connect("localhost:3307", "root", "", "db022");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
 if (!$con)
  {
     die("Connection Failed:".mysqli_connect_error());
}
else
{

 //   $useremail = "jigar@gmail.com";
 //  $userPassword ="1234";

    $userName = $_POST['user_name'];
    $userContact = $_POST['user_contact'];
    $userEmail = $_POST['user_email'];
    $userPassword = $_POST['user_password'];
    //$userPassword =md5($_POST['user_password']);  //for encrypyt password
     
    $sqlQuery = "INSERT INTO user_table (user_name,user_number,user_email,user_password) VALUES ('$userName','$userContact','$userEmail','$userPassword')";
    $result = mysqli_query($con,$sqlQuery);


           
    if($result==1) 
    {
         echo json_encode(["status" => "success"]);
    }     
    else
    {
      echo json_encode(["status" => "error"]);
    }

}  
        