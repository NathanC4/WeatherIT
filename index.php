<?php
include 'web/header.php';
include 'web/home.php';
include 'web/explore.php';
include 'web/manage.php';
include 'web/webadmin.php';
include 'web/logout.php';

$active = isset($_SESSION["logged"]);
$isAdmin = isset($_SESSION["admin"]);
$forwardControl = isset($_GET['destination']) ? $_GET['destination'] : "home";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600&display=swap"
          rel="stylesheet">
    <link href="styles/outline.css" rel="stylesheet" type="text/css">
    <link href="styles/index.css" rel="stylesheet" type="text/css">
    <link href="styles/manage.css" rel="stylesheet" type="text/css">
    <script src="js/controls.js" type="text/javascript"></script>
    <title>WeatherIT</title>
</head>
<body>
<?php
print topControls($active, $isAdmin);
if ($forwardControl === null || $forwardControl === "home") {
    print home();
} elseif ($forwardControl === "explore") {
    print explore();
} elseif ($forwardControl === "manage" && $active) {
    print manage();
} elseif ($forwardControl === "webad" && $active && $isAdmin) {
    print webAdmin();
} elseif ($forwardControl === "login" || $forwardControl === "signup") {
    print "worked";
} elseif ($forwardControl === "logout" && $active) {
    session_destroy();
    $forwardControl = "home";
    print home();
} else {
    header('Location: ./index.php?' . http_build_query(array(
            'failed' => 'yes')));
    print home();
    exit();
}
?>
</body>
<script>
    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://weatherwidget.io/js/widget.min.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'weatherwidget-io-js');
</script>
</html>
