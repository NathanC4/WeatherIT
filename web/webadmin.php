<?php
function webAdmin()
{
    return '
    <section class="options">
        <h3>MANAGE:</h3>
        <button class="profile-button-2" onclick="accessForm(\'server\')">SERVER</button>
        <button class="profile-button-2" onclick="accessForm(\'data\')">DATA</button>
        <button class="profile-button-2" onclick="accessForm(\'users\')">USERS</button>
    </section>
    <section class="information" style="display: block">
            <form class="user-form" id="server" action="index.php?destination=server" method="post">
                <img class="user-icon" src="./content/server.svg" alt="user icon">
                <div class="user-text">MANAGE SERVER</div>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="exit">
                        <img src="./content/error.svg" alt="exit">CANCEL
                    </button>
                    <button class="generic-button" id="button" type="submit" name="status-server" title="status server">
                        <img src="./content/server-status.svg"alt="status server">STATUS
                    </button>
                    <button class="generic-button" id="button" type="submit" name="restart-server" title="restart server">
                        <img src="./content/server-reset.svg"alt="restart server">RESTART
                    </button>
                </div>
            </form>
            
            <form class="user-form" id="data" action="index.php?destination=data" method="post">
                <img class="user-icon" src="./content/database.svg" alt="user icon">
                <div class="user-text">MANAGE DATA</div>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="exit">
                        <img src="./content/error.svg" alt="exit">CANCEL
                    </button>
                    <button class="generic-button" type="submit" name="check-time" title="last time updated">
                        <img src="./content/time.svg"alt="last time updated">C.TIME
                    </button>                    
                    <button class="generic-button" type="submit" name="refresh-data" title="refresh data">
                        <img src="./content/reload.svg"alt="refresh data">UPDATE
                    </button>
                </div>
            </form>
            
            <form class="user-form" id="users" action="index.php?destination=manageusers" method="post">
                <img class="user-icon" src="./content/users.svg" alt="user icon">
                <div class="user-text">MANAGE USERS</div>
                <div class="button-container">
                    <button class="generic-button" type="reset" onclick="hideForm()" title="exit">
                        <img src="./content/error.svg" alt="exit">CANCEL
                    </button>
                    <button class="generic-button" type="submit" name="admin-list" title="manage admins">
                        <img src="./content/users-admin.svg" alt="manage admins">ADMINS
                    </button>
                    <button class="generic-button" type="submit" name="users-list" title="manage admins">
                        <img src="./content/users-list.svg" alt="manage users">USERS
                    </button>
                </div>
            </form>
            
    </section>
    <section class="content-webadmin">

    </section>
    ';
}
