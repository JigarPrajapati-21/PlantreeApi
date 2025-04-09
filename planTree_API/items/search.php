<?php
include'../connection.php';
$typedKeyWords= $_POST['typedKeywords'];

$sqlQuery = "SELECT * FROM items_table WHERE name LIKE'%$typedKeyWords%'";
$resultOfQuery =mysqli_query($con,$sqlQuery);
$count=mysqli_num_rows($resultOfQuery);

if($count > 0)
{
    $foundItemsRecord = array();
    while($rowFound = mysqli_fetch_assoc($resultOfQuery))
    {
            //Encode the image to Base64 if it exists
        if($rowFound['image']){
            //Retrieve the binary data from the database
            $imageData =  $rowFound['image'];
            //Encode the image sdata to Base64
            $rowFound['image'] = base64_encode($imageData);
        }else{
            $rowFound['image']=null;
        }
        $foundItemsRecord[]= $rowFound;
    }

    echo json_encode(
        array(
            "success"=> true,
            "itemsFoundData"=>$foundItemsRecord,
        )
        );
}else{
    echo json_encode(array("success"=> false));
            
}