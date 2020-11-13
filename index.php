<?php
include 'controllers/User.php';
include 'controllers/Location.php';
include 'web/header.php';
include 'web/home.php';
include 'web/explore.php';
include 'web/manage.php';
include 'web/webadmin.php';
include 'web/logout.php';
include 'web/attributes.php';
include 'web/map.php';


if (session_id() == '') {
    session_start();
    if (!isset($_SESSION["logged"])) {
        $_SESSION["logged"] = false;
    }
    if (!isset($_SESSION["admin"])) {
        $_SESSION["admin"] = false;
    }
}

$active = $_SESSION["logged"];
$isAdmin = $_SESSION["admin"];
$forwardControl = isset($_GET['destination']) ? $_GET['destination'] : "home";
$httpHeader = array();
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
    <link href="styles/weather.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="./content/icon.png"/>
    <script src="js/controls.js" type="text/javascript"></script>
    <title>WeatherIT: simple and easy-to-use weather information</title>
</head>
<body>
<?php
print topControls($active, $isAdmin);
if ($forwardControl === null || $forwardControl === "home") {
    print home();
    $launch = new Location();
    if (!$active) {
        if ($launch->explore()) {
            print map($launch->getLatitude(), $launch->getLongitude(), $launch->getZoom());
        } else {
            print map(30.267151, -97.743057, 7);
        }
    } else {
        if ($launch->getLocationDetails($_SESSION["username"])) {
            print $launch->locationText(null);
            print map($launch->getLatitude(), $launch->getLongitude(), $launch->getZoom());
        } else {
            $launch->explore();
            print map($launch->getLatitude(), $launch->getLongitude(), $launch->getZoom());
        }
    }
    print attributes();
} elseif ($forwardControl === "explore") {
    print explore($active);
    $rand = new Location();
    $rand->explore() ? print $rand->locationText(null) : null;
    $rand->explore() ? print $rand->locationText(null) : null;
    $rand->explore() ? print $rand->locationText(null) : null;
    if ($rand->explore()) {
        print $rand->locationText(null);
        print map($rand->getLatitude(), $rand->getLongitude(), $rand->getZoom());
    } else {
        print map(30.267151, -97.743057, 7);
    }
    print attributes();
} elseif ($forwardControl === "manage" && $active) {
    print manage();
    print attributes();
} elseif ($forwardControl === "webad" && $active && $isAdmin) {
    print webAdmin();
    print attributes();
} elseif ($forwardControl === "login") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $user = new User();
        $user->setUsername($_POST["username"]);
        $user->setPassword($_POST["password"]);
        $verified = $user->verifyAccess();

        if ($verified) {
            array_push($httpHeader, $httpHeader['destination'] = 'home' . $httpHeader['success'] = 'true');
            header('Location: ./index.php?', http_build_query($httpHeader));
            print home();
            print map(30.267151, -97.743057, 7);
            print attributes();
        } else {
            array_push($httpHeader, $httpHeader['destination'] = 'home' . $httpHeader['failedlogin'] = 'true');
            header('Location: ./index.php?', http_build_query($httpHeader));
            print home();
            print attributes();
        }
    } else {
        array_push($httpHeader, $httpHeader['destination'] = 'home' . $httpHeader['failedlogin'] = 'true');
        header('Location: ./index.php?', http_build_query($httpHeader));
        print home();
        print attributes();
    }
} elseif ($forwardControl === "signup") {
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmpassword"]) && isset($_POST["email"])) {

        if ($_POST["password"] === $_POST["confirmpassword"]) {
            $user = new User();
            $user->setUsername($_POST["username"]);
            $user->setPassword($_POST["password"]);
            $user->setEmail($_POST["email"]);
            $verified = $user->createAccess();

            if ($verified) {
                array_push($httpHeader, $httpHeader['destination'] = 'home', $httpHeader['success'] = 'true');
                header('Location: ./index.php?' . http_build_query($httpHeader));
                print home();
                print map(30.267151, -97.743057, 7);
                print attributes();
            } else {
                array_push($httpHeader, $httpHeader['destination'] = 'home', $httpHeader['failedlogin'] = 'true');
                header('Location: ./index.php?' . http_build_query($httpHeader));
                print home();
                print attributes();
            }
        }
    } else {
        array_push($httpHeader, $httpHeader['destination'] = 'home', $httpHeader['failedlogin'] = 'true');
        header('Location: ./index.php?' . http_build_query($httpHeader));
        print home();
        print attributes();
    }
} elseif ($forwardControl === "logout" && $active) {
    session_destroy();
    array_push($httpHeader, $httpHeader['destination'] = 'home', $httpHeader['logout'] = 'true');
    header('Location: ./index.php?' . http_build_query($httpHeader));
    $forwardControl = "home";
    print home();
    print map(30.267151, -97.743057, 7);
    print attributes();
} else {
    array_push($httpHeader, $httpHeader['destination'] = 'home', $httpHeader['failed'] = 'true');
    header('Location: ./index.php?' . http_build_query($httpHeader));
    print home();
    print map(30.267151, -97.743057, 7);
    print attributes();
}
exit();
?>
</body>
</html>
