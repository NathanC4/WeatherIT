<?php
$active = isset($_SESSION["logged"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600&display=swap"
          rel="stylesheet">
    <link href="styles/outline.css" rel="stylesheet" type="text/css">
    <link href="styles/index.css" rel="stylesheet" type="text/css">
    <script src="js/controls.js" type="text/javascript"></script>
    <title>WeatherIT</title>
</head>
<body>
<section class="header">
    <div class="logo">
        <img src="./content/logo.svg" alt="weather logo">
        <h1 class="title">WeatherIT</h1>
    </div>
    <div class="menu">
        <a href="index.php" target="_self">HOME</a>
        <a href="index.php" target="_self">EXPLORE</a>
        <?php
        if ($active == false) {
            print '<button class="profile-button" onclick="accessForm(\'login\')">LOGIN</button>
                        <button class="profile-button" onclick="accessForm(\'signup\')">SIGNUP</button>';
        } else {
            print '<a href="index.php" target="_self">PROFILE</a>';
            print '<button class="profile-button" onclick="">LOGOUT</button>';
        }
        ?>
        <form class="search-form" action="" method="post">
            <input class="search-bar" type="search" name="search" placeholder="search locations..">
            <button type="submit"><img src="./content/search.svg" alt="spotlight tool for search"></button>
        </form>
    </div>
</section>
<section class="information" style="display: block">
    <form class="user-form" id="login" action="" method="post">
        <img class="user-icon" src="./content/user.svg" alt="user icon">
        <div class="user-text">LOGIN</div>
        <input class="text-input" type="text" name="username" placeholder="username.." required>
        <input class="text-input" type="password" name="password" placeholder="password.." required>
        <div class="button-container">
            <button class="generic-button" type="reset" onclick="hideForm()" title="cancel login"><img
                        src="./content/error.svg" alt="cancel login"></button>
            <button class="generic-button" type="submit" title="login to your account"><img src="./content/success.svg"
                                                                                            alt="submit login"></button>
        </div>
    </form>
    <form class="user-form" id="signup" action="" method="post">
        <img class="user-icon" src="./content/user.svg" alt="user icon">
        <div class="user-text">SIGNUP</div>
        <input class="text-input" type="email" name="email" placeholder="email.." required>
        <input class="text-input" type="text" name="username" placeholder="username.." required>
        <input class="text-input" type="password" name="password" placeholder="password.." required>
        <input class="text-input" type="password" name="confirmpassword" placeholder="confirm password.." required>
        <div class="button-container">
            <button class="generic-button" type="reset" onclick="hideForm()" title="cancel profile creation"><img
                        src="./content/error.svg" alt="cancel profile"></button>
            <button class="generic-button" type="submit" title="submit your profile"><img src="./content/success.svg"
                                                                                          alt="submit profile"></button>
        </div>
    </form>
</section>
<section class="content-a">
    <a class="weatherwidget-io" href="https://forecast7.com/en/44d98n93d27/minneapolis/" data-label_1="MINNEAPOLIS"
       data-label_2="WEATHER" data-theme="original">MINNEAPOLIS WEATHER</a>
    <a class="weatherwidget-io" href="https://forecast7.com/en/34d05n118d24/los-angeles/" data-label_1="LOS ANGELES"
       data-label_2="WEATHER" data-theme="original">LOS ANGELES WEATHER</a>
</section>
<section class="content-b">
    <iframe width="100%" height="100%"
            src="https://embed.windy.com/embed2.html?lat=41.079&lon=-93.208&detailLat=43.993&detailLon=-89.604&width=650&height=450&zoom=5&level=surface&overlay=wind&product=ecmwf&menu=&message=&marker=&calendar=now&pressure=&type=map&location=coordinates&detail=true&metricWind=default&metricTemp=default&radarRange=-1"
            frameborder="0">
    </iframe>
</section>
<section class="attributes">
    <p>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a
                href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
</section>
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
