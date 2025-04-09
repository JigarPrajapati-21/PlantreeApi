<?php

header('Content-Type:application/json');

include '../connection.php';


$currentOnlineUserID=$_POST['currentOnlineUserID'];

$sqlQuery="SELECT * FROM cart_table CROSS JOIN items_table WHERE cart_table.user_id='$currentOnlineUserID' AND cart_table.item_id=items_table.item_id ";

$resultOfQuery=mysqli_query($con,$sqlQuery);

$count=mysqli_num_rows($resultOfQuery);

if($count >0)
{
    $cartRecord=array();
    while($rowFound=mysqli_fetch_assoc($resultOfQuery))
    {
        //encode image to base64 if exist
        if($rowFound['image'])
        {
            //retrive binary data from table
            $imageData=$rowFound['image'];
            //encode image data to base64
            $rowFound['image']=base64_encode($imageData);
        }
        else
        {
            $rowFound['image']=null;
        }
        $cartRecord[]=$rowFound;
    }

    echo json_encode(
        array(
        "success"=>true,
        "currentUserCartData"=>$cartRecord,
    )
);

}
else
{
    echo json_encode(array("success"=>false));
}