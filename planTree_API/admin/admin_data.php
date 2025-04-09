<?php  
header("content-Type: application/json");
// $con = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");


// echo "1";

//check connection
if(mysqli_connect_errno()){
    die(json_encode(["status" => "error","message" => "Database connection failed:" . mysqli_connect_errno()]));
}
// echo "2";
//Array to hold the row count fro each table
$tableRowCount = [];
// echo "3";
//Query to fetch all tables in the database
$selQuery = "SHOW TABLES";
$result = mysqli_query($con,$selQuery);
// echo "4";
// echo $selQuery;
if($result){
    // loop through each table
    // echo "5";
    while($row = mysqli_fetch_array($result)){
        $tableName =$row[0];
        // echo "6";
        //Modify the query specifically for orders_table to count only rows with status ="new"
        if($tableName ==="orders_table"){
            $countQuery = "SELECT COUNT(*) AS row_count FROM `$tableName` WHERE status = 'new'";
        }
        else
        {
            $countQuery = "SELECT COUNT(*) AS row_count FROM `$tableName`";
        }
        // echo "7";
        //Query to count rows in the current table
        $countResult = mysqli_query($con,$countQuery);
        // echo "8";
        //check if the count query was successful
        if($countResult){
            $countRow = mysqli_fetch_assoc($countResult);
            $tableRowCounts[$tableName] = intval($countRow['row_count']);
        }else{
            $tableRowCounts[$tableName] ="Error counting rows"; //Error handling for specific table count
        }
    }
    // echo "9";
    //Return the table row ciunt as JSON
    echo json_encode(["status" => "success","data" => $tableRowCounts]);
}
else{
    echo json_encode(["status" => "error","message" => "No table found in the database."]);
}

// //close the connection
// mysqli_close($con);
