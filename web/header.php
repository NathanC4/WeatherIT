<?php

function topControls($loggedIn, $isAdmin)
{
    $header = '
        <section class="header">
        <div class="logo">
            <img src="./content/logo.svg" alt="weather logo">
            <h1 class="title">WeatherIT</h1>
        </div>
        <div class="menu">
            <a href="index.php?destination=home" target="_self">HOME</a>
            <a href="index.php?destination=explore" target="_self">EXPLORE</a>';
    if ($loggedIn == false) {
        $header .= '<button class="profile-button" onclick="accessForm(\'login\')">LOGIN</button>
                        <button class="profile-button" onclick="accessForm(\'signup\')">SIGNUP</button>';
    } else {
        $header .= '<a href="index.php?destination=manage" target="_self">PROFILE</a>';
        $isAdmin ? $header .= '<a href="index.php?destination=webad" target="_self">WEBADMIN</a>' : null;
        $header .= '<a href="index.php?destination=logout"  onclick="">LOGOUT</a>';
    }

    $header .= '
                <form class="search-form" action="" method="post">
                <input class="search-bar" type="search" name="search" placeholder="search locations..">
                <button type="submit"><img src="./content/search.svg" alt="spotlight tool for search"></button>
            </form>
        </div>
    </section>';

    return $header;
}
