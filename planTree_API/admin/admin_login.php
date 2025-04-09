
<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, HEAD, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: content-type');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Vary: Origin");

// $con = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
// $con = mysqli_connect("localhost:3307", "root", "", "db022");

 if (!$con)
  {
     die("Connection Failed:".mysqli_connect_error());
}
else
{

  

 $adminemail = $_POST['admin_email'];
 $adminPassword = $_POST['admin_password'];

    
     $sel="SELECT * FROM admin_table WHERE admin_email='".$adminemail."' and admin_password='".$adminPassword."'";       
     $result = mysqli_query($con, $sel);
     $admin_details = [];
     $count = mysqli_num_rows($result);

     while ($row = mysqli_fetch_assoc($result)) {
      $admin_details[] = $row;
      
  }
           
    if($count==1)
    {
      echo json_encode(array(
        "status" => "success",
        "adminData" => $admin_details[0],
    ));
    }     
    else
    {
      echo json_encode(["status" => "error"]);
        //  echo "not connected...";
    }

}  
        