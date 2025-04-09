<?php
header('Content-Type:application/json');
include '../connection.php';

$currentOnlineUserID = $_POST["currentOnlineUserId"]; //'2'; // test with a static value for now

//SQl query to fetch orders history based on user+id andstatus
$sqlQuery = "SELECT *  FROM orders_table WHERE user_id = '$currentOnlineUserID' AND status = 'received' ORDER BY dateTime DESC";
error_log("Executing SQL Query:".$sqlQuery);//log the SQl query

$result = mysqli_query($con,$sqlQuery);
//initialize response array
$response = array();

if($result){
    //check if there are any rows returned
    if(mySqli_num_rows($result)>0){
        $ordersHistoryRecord = [];

        while($row = mysqli_fetch_assoc($result)){
            //Encode the image to Base64 if it exists
            if($row['image']){
               $imageData = $row['image'];
               $row['image'] = base64_encode($imageData);
            }else{
                $row['image'] = null;
            }
            //add the row to the details array
            $ordersHistoryRecord[] = $row;
        }

        //set the response status to success and include the data 
        $response = array(
            "status" => "success",
            "currentUserOrderHistoryData" =>$ordersHistoryRecord
        );
  }  else {
            //no data found, set appropriate response
            $response = array(
            "status" => "success",
            "currentUserOrderHistoryData" => []
            );
        }
        //output the the data in json format
        echo json_encode($response);
    }else{
        //Prepae the error response with MyQSl error message
        $response = array(
        "status" => "error",
        "currentUserOrderHistoryData" => null,
        "error" => mysqli_error($con) //log the actual SQL error for debugging  
        );
        //output the error response in json format
        echo json_encode($response);
    }
