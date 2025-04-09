<?php
// $server = "192.168.10.254";
// $username = "GP2431";
// $password = "O57022";
// $dbname = "gp2431_db";

// $con = mysqli_connect($server, $username, $password, $dbname);

$con = mysqli_connect("localhost", "root", "", "gp2431_db");

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!$con) {
    error_log("Database Connection Failed: " . mysqli_connect_error());
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Check if required POST data is present
if (!isset($_POST['sub_category_name']) ||!isset($_POST['main_category_id']) || !isset($_POST['image'])) {

    echo json_encode(["success" => false, "message" => "Missing required parameters."]);
    exit();
}

// Sanitize and validate the input data
$sub_category_name = $_POST['sub_category_name'];
$main_category_id = $_POST['main_category_id'];
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

// Prepare the SQL query
$stmt = $con->prepare("INSERT INTO sub_category (main_category_id,sub_category_name, image) VALUES (?,?,?)");

if ($stmt === false) {
    error_log("Failed to prepare SQL query: " . mysqli_error($con));
    echo json_encode(["success" => false, "message" => "Server error: Failed to prepare query"]);
    exit();
}

// Bind parameters (do not bind the image yet)
$stmt->bind_param("ssb", $main_category_id,$sub_category_name, $image);

// Bind image as long data
$stmt->send_long_data(2, $image); // The 1 corresponds to the image parameter

// Execute the query
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "sub category inserted successfully"]);
} else {
    error_log("Failed to execute SQL query: " . mysqli_error($con));
    echo json_encode(["success" => false, "message" => "Failed to insert"]);
}

// Close the prepared statement and database connection
$stmt->close();
mysqli_close($con);
