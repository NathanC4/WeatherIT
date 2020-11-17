<?php
function manage()
{
    return '
    <section class="options">
        <h3>CHANGE:</h3>
        <button class="profile-button-2" onclick="accessForm(\'password\')">PASSWORD</button>
        <button class="profile-button-2" onclick="accessForm(\'email\')">EMAIL</button>
        <button class="profile-button-2" onclick="accessForm(\'delete\')">DELETE</button>
    </section>
    <section class="information" style="display: block">
            <form class="user-form" id="password" action="index.php?destination=changepassword" method="post">
                <img class="user-icon" src="./content/user.svg" alt="user icon">
                <div class="user-text">CHANGE PASSWORD</div>
                <input class="text-input" type="password" name="currentpassword" placeholder="current password.." required>
                <input class="text-input" type="password" name="newpassword" placeholder="new password.." required>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="cancel password change">
                        <img src="./content/error.svg" alt="cancel password change">
                    </button>
                    <button class="generic-button" type="submit" title="change your password">
                        <img src="./content/success.svg"alt="submit login">
                    </button>
                </div>
            </form>
            
            <form class="user-form" id="email" action="index.php?destination=changeemail" method="post">
                <img class="user-icon" src="./content/user.svg" alt="user icon">
                <div class="user-text">CHANGE EMAIL</div>
                <input class="text-input" type="email" name="newemail" placeholder="new email.." required>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="cancel email change">
                        <img src="./content/error.svg" alt="cancel email">
                    </button>
                    <button class="generic-button" type="submit" title="cancel your email change">
                        <img src="./content/success.svg" alt="submit email change">
                    </button>
                </div>
            </form>
            
            <form class="user-form" id="delete" action="index.php?destination=deleteaccount" method="post">
                <img class="user-icon" src="./content/users-delete.svg" alt="user icon">
                <div class="user-text">DELETE ACCOUNT</div>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="delete account">
                        <img src="./content/error.svg" alt="cancel delete">
                    </button>
                    <button class="generic-button" type="submit" title="delete account">
                        <img src="./content/success.svg" alt="submit account deletion">
                    </button>
                </div>
            </form>
            
    </section>
    ';
}


