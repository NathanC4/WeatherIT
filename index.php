<?php
include_once 'PageController.php';

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
$forwardControl = "home";

if (isset($_POST['destination'])) {
    $forwardControl = $_POST['destination'];
} else if (isset($_GET['destination'])) {
    $forwardControl = $_GET['destination'];
}

$httpHeader = array();
$requestedPage = new PageController($active, $isAdmin);

if ($forwardControl !== 'favorite') {
    print '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="ISO-8859-1" content="width=device-width,height=device-height,initial-scale=1.0" name="viewport">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600&display=swap"
              rel="stylesheet">
        <link href="./styles/outline.css" rel="stylesheet" type="text/css">
        <link href="./styles/index.css" rel="stylesheet" type="text/css">
        <link href="./styles/manage.css" rel="stylesheet" type="text/css">
        <link href="./styles/weather.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="./content/icon.png"/>
        <script src="./js/controls.js" type="text/javascript"></script>
        <script src="./js/send.js" type="text/javascript"></script>
        <title>WeatherIT: simple and easy-to-use weather information</title>
    </head>
    <body>';
    array_push($httpHeader, $httpHeader['destination'] = 'home');
    $requestedPage->goHeader($active, $isAdmin);

    if ($forwardControl === null || $forwardControl === "home") {
        $requestedPage->goHome();

    } elseif ($forwardControl === "explore") {
        $requestedPage->goExplore();

    } elseif ($forwardControl === "manage" && $active) {
        $requestedPage->goManage();

    } elseif ($forwardControl === "webad" && $active && $isAdmin) {
        $requestedPage->goWebAd();

    } elseif ($forwardControl === "login") {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $requestedPage->goLogin($_POST["username"], $_POST["password"]);
        } else {
            $requestedPage->goMessage(false, "Login");
        }
        header('Location: ./index.php?' . http_build_query($httpHeader));
        $requestedPage->goHome();

    } elseif ($forwardControl === "signup") {
        if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmpassword"]) && isset($_POST["email"])) {
            $requestedPage->goMessage($requestedPage->goSignup($_POST["username"], $_POST["password"], $_POST["confirmpassword"], $_POST["email"]), "Sign-up");
        } else {
            $requestedPage->goMessage(false, "Sign-up");
        }
        header('Location: ./index.php?' . http_build_query($httpHeader));
        $requestedPage->goHome();

    } else if ($forwardControl === 'changepassword') {
        if (isset($_POST["currentpassword"]) && isset($_POST["newpassword"])) {
            $requestedPage->goMessage($requestedPage->goNewPassword($_POST["currentpassword"], $_POST["newpassword"]), 'Updating password');
        } else {
            $requestedPage->goMessage(false, 'Changing password');
        }
        $requestedPage->goManage();

    } else if ($forwardControl === 'changeemail') {
        if (isset($_POST["newemail"])) {
            $requestedPage->goMessage($requestedPage->goNewEmail($_POST["newemail"]), 'Updated email');
        } else {
            $requestedPage->goMessage(false, 'Changing email');
        }
        $requestedPage->goManage();

    } else if ($forwardControl === 'deleteaccount') {
        $requestedPage->goMessage($requestedPage->goDeleteAccount(), 'Account deletion');
        session_destroy();
        header('Location: ./index.php?' . http_build_query($httpHeader));
        $requestedPage->goHome();

    } else if ($forwardControl === 'search') {
        if (isset($_POST["search"])) {
            $requestedPage->goSearch($_POST["search"]);
        } else {
            $requestedPage->goMessage(false, 'Request');
            $requestedPage->goHome();
        }
    } elseif ($forwardControl === "logout" && $active) {
        session_destroy();
        header('Location: ./index.php?' . http_build_query($httpHeader));
        $requestedPage->goMessage(true, 'Logout');
        $requestedPage->goHome();

    } else {
        header('Location: ./index.php?' . http_build_query($httpHeader));
        $requestedPage->goMessage(false, 'Request');
        $requestedPage->goHome();
    }
    print '</body></html>';
    exit();
} else if ($active) {
    isset($_POST["favorite"]) ? $locationID = $_POST["favorite"] : $locationID = $_POST["unfavorite"];
    isset($_POST["favorite"]) ? $type = "favorite" : $type = "unfavorite";
    if ($locationID === null) {
        print "Error: please try again later";
    } else {
        if ($requestedPage->goFavorite($type, $locationID)) {
            print "Successfully completed " . $type;
        } else {
            print "Error: please try again later";
        }
    }
} else {
    header('Refresh:0 ; url=index.php');
}
exit();
