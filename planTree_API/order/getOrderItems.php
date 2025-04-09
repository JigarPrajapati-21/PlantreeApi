<?php
header('Content-Type: application/json');

//database connection settings
// $conn = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
//check connection
if(!$conn){
    die("Connection failed:".mysqli_connect_error());
}
$orderitemsids=$_POST["orderitemsids"];

//Convert JSON string to an array
$array = json_decode($orderitemsids,true);

//convert array to a comma-separated string inside parentheses
$inClause = '('.implode(',',$array).')';

//sql query to fetch all data from the main_category table
$sql = "SELECT * from items_table where item_id in $inClause";

$result = mysqli_query($conn,$sql);

//Initialize response array
$response =array();

if($result){
    //Fetch all rows from the result set
    $ordertemRecord=[];

    while($row = mysqli_fetch_assoc($result)){
        if($row['image']){
            //Retrieve the binary data from the database
            $imageData = $row['image'];
            //Ecode the image data to Base64
            $row['image'] = base64_encode($imageData);
        }else{
            $row['image'] = null;
        }
        //Add the row to the details array
        $orderItemRecord[] = $row;
    }
    //set the response status to success and include the data
    $response = array(
        "status"=> "success",
        "orderItemData" => $orderItemRecord
    );
    //output the data in json format
    echo json_encode($response);
}else{
    //prepare the error response
    $response = array(
        "status"=> "error",
        "message"=> "Failed to fetch data"
    );
    //Output the error response in json fromat
    echo json_encode($response);
}
//Close the database connection
mysqli_close($conn);