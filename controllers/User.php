<?php
include_once 'QueryDB.php';

class User
{
    private $username;
    private $password;
    private $email;

    function __construct()
    {
        $this->qdb = new QueryDB();
    }

    /**
     * @param $value
     * set the username value of the user object
     */
    function setUsername(string $value)
    {
        $this->username = $value;
    }

    /**
     * @param $value
     * set the password value of the user object as a hash
     */
    function setPassword(string $value)
    {
        $this->password = (string)password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * @param string $email
     * set the email of the user object
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return bool
     * upon successful insert the user is then logged in and a value of true is returned based on login success
     * otherwise the value is false for any failures and returned back
     */
    function createAccess()
    {

        $SQL = "INSERT INTO USERS (username, password, email, isAdmin) VALUES ('$this->username', '$this->password', '$this->email', default)";
        $queryResults = $this->qdb->executeSQL($SQL);
        if ($queryResults) {
            return true;
        } else {
            return false;
        }
    }

    function verifyAccess($userEnteredPassword)
    {
        $SQL = "SELECT * FROM USERS WHERE username='{$this->username}'";
        $queryResults = $this->qdb->fetchRow($SQL);
        $bool = false;
        if (isset($queryResults["password"])) {
            $bool = password_verify($userEnteredPassword, $queryResults["password"]);
            isset($queryResults["username"]) ? $_SESSION["username"] = $queryResults["username"] : null;
            isset($queryResults["username"]) ? $_SESSION["logged"] = true : $_SESSION["logged"] = false;
            isset($queryResults["username"]) && $queryResults["isAdmin"] === "1" ?
                $_SESSION["admin"] = true : $_SESSION["admin"] = false;
        }
        return $bool;
    }

    function addFavorite($location_id)
    {
        $query = "INSERT INTO USERS_FAVORITES (username, location_id) VALUES ('$this->username', $location_id)";
        return $this->qdb->executeSQL($query);
    }

    function removeFavorite($location_id)
    {
        $query = "DELETE FROM USERS_FAVORITES WHERE username='$this->username' AND location_id=$location_id";
        return $this->qdb->executeSQL($query);
    }

    function changePassword($oldPassword, $newPassword)
    {
        $this->password = $oldPassword;
        if ($this->verifyAccess($oldPassword)) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE USERS SET password='$newPasswordHash' WHERE username='$this->username'";
            return $this->qdb->executeSQL($query);
        } else {
            return false;
        }
    }

    function changeEmail($newEmail)
    {
        $query = "UPDATE USERS SET email='$newEmail' WHERE username='$this->username'";
        return $this->qdb->executeSQL($query);
    }

    function deleteAccount()
    {
        $queryA = "DELETE FROM USERS_FAVORITES WHERE username='$this->username'";
        $queryB = "DELETE FROM USERS WHERE username='$this->username'";
        $resultsA = $this->qdb->executeSQL($queryA);
        $resultsB = $this->qdb->executeSQL($queryB);
        return ($resultsA === true && $resultsB === true);
    }
}
