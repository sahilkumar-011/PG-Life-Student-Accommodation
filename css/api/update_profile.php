<?php
session_start();
require("../includes/database_connect.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in to edit your profile."]);
    return;
}

$user_id = $_SESSION['user_id'];

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$college_name = $_POST['college_name'];
$gender = $_POST['gender'];
$note = $_POST['note'] ?? '';
$password = $_POST['password'] ?? '';

// Make sure the email isn't already used by a different account
$stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? AND id != ?");
mysqli_stmt_bind_param($stmt_check, "si", $email, $user_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
if (!$result_check) {
    echo json_encode(["success" => false, "message" => "Something went wrong!"]);
    return;
}
if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(["success" => false, "message" => "This email is already in use by another account."]);
    return;
}

if (!empty($password)) {
    $hashed_password = sha1($password);
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, phone = ?, email = ?, college_name = ?, gender = ?, note = ?, password = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssssssi", $full_name, $phone, $email, $college_name, $gender, $note, $hashed_password, $user_id);
} else {
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, phone = ?, email = ?, college_name = ?, gender = ?, note = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssssi", $full_name, $phone, $email, $college_name, $gender, $note, $user_id);
}

$result = mysqli_stmt_execute($stmt);
if (!$result) {
    echo json_encode(["success" => false, "message" => "Something went wrong! Please try again."]);
    return;
}

echo json_encode(["success" => true, "message" => "Your profile has been updated successfully!"]);
mysqli_close($conn);
