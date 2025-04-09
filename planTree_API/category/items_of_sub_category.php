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

    $subCategoryID=$_POST['sub_category_id'];
    $sql="SELECT * FROM items_table WHERE sub_category_id='$subCategoryID'";
    
    $result=mysqli_query($con,$sql);
    
    $response=array();
    
    if($result)
    {
        $plantItemRecord=[];
    
        while($row=mysqli_fetch_assoc($result))
        {
            if($row['image'])
            {
                $imageData=$row['image'];
                $row['image']=base64_encode($imageData);
            }else{
                $row['image']=null;
            }
            $plantItemRecord[]=$row;
        }
    
    
        $response=array(
            "status"=>"success",
            "plantItemData"=>$plantItemRecord
        );
    
        echo json_encode($response);
    
    }else{
        $response=array(
            "status"=>"error",
            "message"=>"Failed to fetch data"
        );
    
        echo json_encode($response);
    }
    
    
  
}  