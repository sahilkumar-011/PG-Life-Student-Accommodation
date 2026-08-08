<?php
session_start();

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require "../includes/database_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false));
    return;
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET["property_id"];

if (!ctype_digit((string) $property_id)) {
    echo json_encode(array("success" => false, "message" => "Invalid property"));
    return;
}

$stmt_1 = mysqli_prepare($conn, "SELECT * FROM interested_users_properties WHERE user_id = ? AND property_id = ?");
mysqli_stmt_bind_param($stmt_1, "ii", $user_id, $property_id);
mysqli_stmt_execute($stmt_1);
$result_1 = mysqli_stmt_get_result($stmt_1);
if (!$result_1) {
    echo json_encode(array("success" => false, "message" => "Something went wrong"));
    return;
}

if (mysqli_num_rows($result_1) > 0) {
    $stmt_2 = mysqli_prepare($conn, "DELETE FROM interested_users_properties WHERE user_id = ? AND property_id = ?");
    mysqli_stmt_bind_param($stmt_2, "ii", $user_id, $property_id);
    $result_2 = mysqli_stmt_execute($stmt_2);
    if (!$result_2) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_interested" => false, "property_id" => $property_id));
        return;
    }
} else {
    $stmt_3 = mysqli_prepare($conn, "INSERT INTO interested_users_properties (user_id, property_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt_3, "ii", $user_id, $property_id);
    $result_3 = mysqli_stmt_execute($stmt_3);
    if (!$result_3) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_interested" => true, "property_id" => $property_id));
        return;
    }
}
