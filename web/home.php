<?php
function home()
{
    return '
    <section class="information" style="display: block">
        <form class="user-form" id="login" action="index.php?destination=login" method="post">
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
        <form class="user-form" id="signup" action="index.php?destination=signup" method="post">
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
    </section>';
}



