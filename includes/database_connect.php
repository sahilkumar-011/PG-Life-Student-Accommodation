<?php
// TODO: Replace these 4 values with the ones from your InfinityFree control panel
// (MySQL Databases section). Host is usually something like "sqlXXX.infinityfree.com".
$db_host = "YOUR_DATABASE_HOST";
$db_user = "YOUR_DATABASE_USERNAME";
$db_pass = "YOUR_DATABASE_PASSWORD";
$db_name = "YOUR_DATABASE_NAME";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    // Throw error message based on ajax or not
    echo "Failed to connect to MySQL! Please contact the admin.";
    return;
}
