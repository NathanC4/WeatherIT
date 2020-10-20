<?php

function explore($loggedIn)
{
    if (!$loggedIn) {
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
        </section>';
    } else {
        return '';
    }
}
