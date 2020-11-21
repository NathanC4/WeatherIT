<?php
include_once './controllers/WeatherManager.php';
include_once './controllers/User.php';
include_once './web/header.php';
include_once './web/home.php';
include_once './web/explore.php';
include_once './web/manage.php';
include_once './web/webadmin.php';
include_once './web/attributes.php';
include_once './web/message.php';

class PageController
{
    private $active;
    private $admin;
    private $weather;

    public function __construct($activeUser, $activeAdmin)
    {
        $this->weather = new WeatherManager();
        $this->active = $activeUser;
        $this->admin = $activeAdmin;
    }

    function goHeader($isActive, $isAdmin)
    {
        print topControls($isActive, $isAdmin);
    }

    function goBanner()
    {
        $icons = new Weather();
        $html = '<div class="banner">';
        $html .= '<div class="banner-icons"><p class="banner-text">12:00 </p>' . $icons->sunny() . '<p class="banner-text">12:01 </p>' . $icons->snow() . '</div>';
        $html .= '<h3 class="banner-header">Weather is unpredictable;<br>WeatherIT makes it predictable;</h3>';
        $html .= '</div>';
        print $html;
    }

    function goHome()
    {
        print home();
        if (!$this->active) {
            $this->goBanner();
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

    function goLogin($username, $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        return $user->verifyAccess($password);
    }

    function goSignup($username, $password, $confirmPassword, $email)
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

    function goNewPassword($oldPassword, $newPassword)
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->changePassword($oldPassword, $newPassword);
        }
        return false;
    }

    function goNewEmail($newEmail)
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->changeEmail($newEmail);
        }
        return false;
    }

    function goDeleteAccount()
    {
        if (isset($_SESSION["username"])) {
            $user = new User();
            $user->setUsername($_SESSION["username"]);
            return $user->deleteAccount();
        }
        return false;
    }

    function goFavorite($type, $id)
    {
        $user = new User();
        $user->setUsername($_SESSION["username"]);
        if ($type === "unfavorite") {
            return $user->removeFavorite((float)$id);
        } else {
            return $user->addFavorite((float)$id);
        }
    }

    function goSearch($search)
    {
        $results = $this->weather->showResults($search);
        print $results;
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
