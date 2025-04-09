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

  
    $mainCategoryID=$_POST['main_category_id'];
    $sql="SELECT * FROM sub_category WHERE main_category_id='$mainCategoryID' ";
    
    $result=mysqli_query($con,$sql);
    
    $response=array();
    
    if($result)
    {
        $subCategoryRecord=[];
    
        while($row=mysqli_fetch_assoc($result))
        {
            if($row['image'])
            {
                $imageData=$row['image'];
                $row['image']=base64_encode($imageData);
            }else{
                $row['image']=null;
            }
            $subCategoryRecord[]=$row;
        }
    
    
        $response=array(
            "status"=>"success",
            "subCategoryData"=>$subCategoryRecord
        );
    
        echo json_encode($response);
    
    }else{
        $response=array(
            "status"=>"error",
            "message"=>"Failed to fetch sub category data"
        );
    
        echo json_encode($response);
    }
    
    
  
}  