<?php

header('Content-Type:application/json');


// $con = mysqli_connect("192.168.10.254", "GP2431", "O57022", "gp2431_db");

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
if (!$con)
  {
     die("Connection Failed:".mysqli_connect_error());
}
else
{

   
    
     $sel="SELECT * FROM items_table ORDER BY RAND()";       
     $result = mysqli_query($con, $sel);
    
     $response=array();
     if($result)
     {
        $allItemRecord=[];

        while ($row = mysqli_fetch_assoc($result)) {
            //encode image to base64
            if($row['image'])
            {
                //retrive binary data from database
                $imageData=$row['image'];
                //encode to base64
                $row['image']=base64_encode($imageData);
            }
            else
            {
                $row['image']=null;

            }
        
            $allItemRecord[]=$row;

        }

        $response=array(
            "status"=>"success",
            "allItemData"=>$allItemRecord
        );

        echo json_encode($response);


     }else{
        $response=array(
            "status"=>"erroe",
            "allItemData"=>"failed to fetch data"
        );
        echo json_encode($response);

     }
}  