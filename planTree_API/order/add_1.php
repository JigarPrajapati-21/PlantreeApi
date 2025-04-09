<?php

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
// $server = "192.168.10.254";
// $username = "GP2431";
// $password = "O57022";
// $dbname = "gp2431_db";

// $con = mysqli_connect($server, $username, $password, $dbname);

$con = mysqli_connect("localhost", "root", "", "gp2431_db");
if (!$con) {
    error_log("Database Connection Failed: " . mysqli_connect_error());
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Check if required POST data is present
if (!isset($_POST['user_id']) || !isset($_POST['deliverySystem']) || !isset($_POST['paymentSystem']) ||
    !isset($_POST['note']) || !isset($_POST['totalAmount']) || !isset($_POST['image']) ||
    !isset($_POST['shipmentAddress']) || !isset($_POST['name']) || !isset($_POST['phoneNumber']) || !isset($_POST['itemsData'])) {

    echo json_encode(["success" => false, "message" => "Missing required parameters."]);
    exit();
}

// Sanitize and validate the input data
$userId = intval($_POST['user_id']);
$deliverySystem = mysqli_real_escape_string($con, $_POST['deliverySystem']);
$paymentSystem = mysqli_real_escape_string($con, $_POST['paymentSystem']);
$note = mysqli_real_escape_string($con, $_POST['note']);
$totalAmount = floatval($_POST['totalAmount']);
$imageData = $_POST['image'];

// Clean the base64 string if it contains a prefix
if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
    $imageData = substr($imageData, strpos($imageData, ',') + 1);
}

// Decode the image data
$image = base64_decode($imageData);
if ($image === false) {
    echo json_encode(["success" => false, "message" => "Invalid image data"]);
    exit();
}

$status = 'new';
$shipmentAddress = mysqli_real_escape_string($con, $_POST['shipmentAddress']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
$itemsData = mysqli_real_escape_string($con, $_POST['itemsData']);

// Prepare the SQL query
$stmt = $con->prepare("INSERT INTO orders_table (user_id, deliverySystem, paymentSystem, note, totalAmount, status, shipmentAddress, name, phoneNumber, itemsdata, image) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    error_log("Failed to prepare SQL query: " . mysqli_error($con));
    echo json_encode(["success" => false, "message" => "Server error: Failed to prepare query"]);
    exit();
}

// Bind parameters (do not bind the image yet)
$stmt->bind_param("isssdsssssb", $userId, $deliverySystem, $paymentSystem, $note, $totalAmount, $status, $shipmentAddress, $name, $phoneNumber, $itemsData, $image);

// Bind image as long data
$stmt->send_long_data(10, $image); // The 10  corresponds to the image parameter

// Execute the query
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Order placed successfully"]);
} else {
    error_log("Failed to execute SQL query: " . mysqli_error($con));
    echo json_encode(["success" => false, "message" => "Failed to insert order"]);
}

// Close the prepared statement and database connection
$stmt->close();
mysqli_close($con);


// // Enable error reporting for debugging (disable in production)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// // Database connection
// $server = "192.168.10.254";
// $username = "GP2431";
// $password = "O57022";
// $dbname = "gp2431_db";

// $con = mysqli_connect($server, $username, $password, $dbname);

// if (!$con) {
//     // Log and return error if database connection fails
//     error_log("Database Connection Failed: " . mysqli_connect_error());
//     echo json_encode(["success" => false, "message" => "Database connection failed"]);
//     exit();
// }

// // Check if required POST data is present
// if (!isset($_POST['user_id']) || !isset($_POST['deliverySystem']) || !isset($_POST['paymentSystem']) ||
//     !isset($_POST['note']) || !isset($_POST['totalAmount']) || !isset($_POST['image']) ||
//     !isset($_POST['shipmentAddress']) || !isset($_POST['phoneNumber']) || !isset($_POST['itemsData'])) {

//     echo json_encode(["success" => false, "message" => "Missing required parameters."]);
//     exit();
// }

// // Sanitize and validate the input data
// $userId = intval($_POST['user_id']); // Ensure it's an integer
// $deliverySystem = mysqli_real_escape_string($con, $_POST['deliverySystem']);
// $paymentSystem = mysqli_real_escape_string($con, $_POST['paymentSystem']);
// $note = mysqli_real_escape_string($con, $_POST['note']);
// $totalAmount = floatval($_POST['totalAmount']); // Ensure it's a float
// $image = base64_decode($_POST['image']); // Decode the base64 image
// $status = 'new'; // Default status for new order
// $shipmentAddress = mysqli_real_escape_string($con, $_POST['shipmentAddress']);
// $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
// $itemsData = mysqli_real_escape_string($con, $_POST['itemsData']); // JSON string of items

// // Check if the image is valid (not empty after decoding)
// if ($image === false) {
//     echo json_encode(["success" => false, "message" => "Invalid image data"]);
//     exit();
// }

// // Change the column type to TEXT if it's too small (if needed, run an SQL query to modify the column type)

// // Prepare the SQL query using prepared statements to avoid SQL injection
// $stmt = $con->prepare("INSERT INTO orders_table (user_id, deliverySystem, paymentSystem, note, totalAmount, status, shipmentAddress, phoneNumber, itemsdata) 
//                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

// if ($stmt === false) {
//     error_log("Failed to prepare SQL query: " . mysqli_error($con));
//     echo json_encode(["success" => false, "message" => "Server error: Failed to prepare query"]);
//     exit();
// }

// // Bind parameters to the SQL query
// $stmt->bind_param("isssdssss", $userId, $deliverySystem, $paymentSystem, $note, $totalAmount, $status, $shipmentAddress, $phoneNumber, $itemsData);

// // Execute the query
// if ($stmt->execute()) {
//     // Optionally, you can save the image to the server here (not implemented in this example)
//     // file_put_contents('images/' . $userId . '_order_image.jpg', $image);

//     // Respond with success
//     echo json_encode(["success" => true, "message" => "Order placed successfully"]);
// } else {
//     // Log the error if the query fails
//     error_log("Failed to execute SQL query: " . mysqli_error($con));
//     echo json_encode(["success" => false, "message" => "Failed to insert order"]);
// }

// // Close the prepared statement and database connection
// $stmt->close();
// mysqli_close($con);

