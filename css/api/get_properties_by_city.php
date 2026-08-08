<?php
session_start();

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require "../includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$city_name = $_GET["city"];

$stmt_1 = mysqli_prepare($conn, "SELECT * FROM cities WHERE name = ?");
mysqli_stmt_bind_param($stmt_1, "s", $city_name);
mysqli_stmt_execute($stmt_1);
$result_1 = mysqli_stmt_get_result($stmt_1);
if (!$result_1) {
    echo json_encode([]);
    return;
}
$city = mysqli_fetch_assoc($result_1);
if (!$city) {
    echo json_encode([]);
    return;
}
$city_id = $city['id'];

$sql_2 = "SELECT * FROM properties WHERE city_id = $city_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo json_encode([]);
    return;
}
$properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);


$sql_3 = "SELECT * 
            FROM interested_users_properties iup
            INNER JOIN properties p ON iup.property_id = p.id
            WHERE p.city_id = $city_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo json_encode([]);
    return;
}
$interested_users_properties = mysqli_fetch_all($result_3, MYSQLI_ASSOC);


$new_properties = array();
foreach ($properties as $property) {
    $property_images = glob("../img/properties/" . $property['id'] . "/*");
    if (!empty($property_images)) {
        $property_image = "img/properties/" . $property['id'] . "/" . basename($property_images[0]);
    } else {
        $property_image = "img/no_image.jpg";
    }

    $interested_users_count = 0;
    $is_interested = false;
    foreach ($interested_users_properties as $interested_user_property) {
        if ($interested_user_property['property_id'] == $property['id']) {
            $interested_users_count++;

            if ($interested_user_property['user_id'] == $user_id) {
                $is_interested = true;
            }
        }
    }
    $property['interested_users_count'] = $interested_users_count;
    $property['is_interested'] = $is_interested;
    $property['image'] = $property_image;
    $new_properties[] = $property;
}

echo json_encode($new_properties);
