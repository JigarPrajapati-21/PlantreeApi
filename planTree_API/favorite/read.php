<?php

include '../connection.php';


$currentOnlineUserID= $_POST['user_id'];

$sqlQuery="SELECT * FROM favorite_table CROSS JOIN items_table WHERE favorite_table.user_id='$currentOnlineUserID' AND favorite_table.item_id=items_table.item_id ";

$resultOfQuery=mysqli_query($con,$sqlQuery);

$count=mysqli_num_rows($resultOfQuery);

if($count >0)
{
    $favoriteRecord=array();
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
        $favoriteRecord[]=$rowFound;
    }

    echo json_encode(
        array(
        "success"=>true,
        "currentUserFavoriteData"=>$favoriteRecord,
    )
);

}
else
{
    echo json_encode(array("success"=>false));
}