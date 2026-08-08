<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Project | PG Life</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/demo_notice.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <div class="demo-notice-container">
        <div class="demo-notice-icon">🎓</div>
        <h2 class="demo-notice-title">This is a Demo Project</h2>
        <p class="demo-notice-text">
            PG Life is a personal/portfolio project built to demonstrate web development
            skills — it is not a real, functioning booking platform. The booking feature
            you just clicked is not connected to any live payment or reservation system.
        </p>
        <p class="demo-notice-text">
            Thanks for checking it out! Feel free to explore the rest of the site.
        </p>
        <a href="javascript:history.back()" class="demo-notice-btn">Go back</a>
    </div>

    <?php
    include "includes/footer.php";
    ?>
</body>

</html>
