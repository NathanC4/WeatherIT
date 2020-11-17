<?php
include 'controllers/WeatherManager.php';
include 'controllers/User.php';
include 'web/header.php';
include 'web/home.php';
include 'web/explore.php';
include 'web/manage.php';
include 'web/webadmin.php';
include 'web/attributes.php';
include 'web/message.php';
include 'web/search.php';

class PageController
{
    private WeatherManager $weather;
    private string $active;
    private string $admin;

    public function __construct($activeUser, $activeAdmin)
    {
        $this->weather = new WeatherManager();
        $this->active = $activeUser;
        $this->admin = $activeAdmin;
    }

    function goHome()
    {
        print home();
        if (!$this->active) {
            print $this->weather->showRandom(1);
        } else {
            print $this->weather->showFavorites();
        }
        print attributes();
    }

    function goExplore()
    {
        print explore($this->active);
        print $this->weather->showRandom(4);
        print attributes();
    }

    function goManage()
    {
        if ($this->active) {
            print manage();
            print attributes();
        } else {
            $this->goHome();
        }
    }

    function goWebAd()
    {
        if ($this->active && $this->admin) {
            print webAdmin();
            print attributes();
        } else {
            $this->goHome();
        }
    }

    function goLogin($username, $password): bool
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        return $user->verifyAccess($password);
    }

    function goSignup($username, $password, $confirmPassword, $email): bool
    {
        if ($password === $confirmPassword) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->createAccess();
            $user->verifyAccess($password);
            return true;
        }
        return false;
    }

    function goNewPassword($oldPassword, $newPassword): bool
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->changePassword($oldPassword, $newPassword);
        }
        return false;
    }

    function goNewEmail($newEmail): bool
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->changeEmail($newEmail);
        }
        return false;
    }

    function goDeleteAccount(): bool
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->deleteAccount();
        }
        return false;
    }

    function goFavorite($action): bool
    {
        return false;
    }

    function goSearch()
    {

    }

    function goMessage($result, $word)
    {
        if ($result) {
            print messageSuccess($word);
        } else {
            print messageFailure($word);
        }
    }
}
