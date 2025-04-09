<?php

header('Content-Type:application/json');
include '../connection.php';

$response=array();


    $currentOnlineUserId=$_POST['currentOnlineUserId'];

    $selQuery="SELECT * FROM orders_table WHERE user_id='$currentOnlineUserId' AND status='new' ORDER BY dateTime DESC";

    error_log("Executing SQL Query : ".$selQuery);


    $result=mysqli_query($con,$selQuery);

    $response=array();

    if($result)
    {
        
        if(mysqli_num_rows($result)>0)
        {
            $ordersRecord=[];

            while($row=mysqli_fetch_assoc($result))
            {


                if($row['image']){
                    $imageData=$row['image'];
                    $row['image']=base64_encode($imageData);
                }else{
                    $row['image']=null;
                }
    
                $ordersRecord[]=$row;

            }

            $response=array(
                    "status"=>"success",
                    "currentUserOrdersData"=>$ordersRecord
            );
            
        }else{
            $response=array(
                "status"=>"success",
                "currentUserOrdersData"=>[]
        );
        }

        echo json_encode($response);

    }else
    {
        $response=array(
            "status"=>"error",
            "currentUserOrdersData"=>null,
            "error"=>mysqli_error($con)
        );

        echo json_encode($response);
    }


  