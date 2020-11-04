<?php
include_once 'QueryDB.php';

class User
{
    private $username;
    private $password;
    private $email;

    function __construct()
    {
        $this->db = new QueryDB();
    }

    /**
     * @param $value
     * set the username value of the user object
     */
    function setUsername($value)
    {
        $this->username = $value;
    }

    /**
     * @param $value
     * set the password value of the user object
     */
    function setPassword($value)
    {
        $this->password = $value;
    }

    /**
     * @param string $email
     * set the email of the user object
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     * upon successful insert the user is then logged in and a value of true is returned based on login success
     * otherwise the value is false for any failures and returned back
     */
    function createAccess(): bool
    {

        $SQL = "INSERT INTO USERS (username, password, email, isAdmin) VALUES ('$this->username', '$this->password', '$this->email', default)";
        $queryResults = $this->db->executeSQL($SQL);
        if ($queryResults) {
            return $this->verifyAccess();
        } else {
            return false;
        }
    }

    function verifyAccess(): bool
    {
        $SQL = "SELECT * FROM USERS WHERE username='{$this->username}'";
        $queryResults = $this->db->fetchRow($SQL);
        isset($queryResults["username"]) ? $_SESSION["username"] = $queryResults["username"] : null;
        isset($queryResults["username"]) ? $_SESSION["logged"] = true : $_SESSION["logged"] = false;
        isset($queryResults["username"]) && $queryResults["isAdmin"] === "1" ?
            $_SESSION["admin"] = true : $_SESSION["admin"] = false;

        $this->db->closeConnection();
        return isset($queryResults["username"]);
    }

    function addFavorite($favorite)
    {

    }

    function removeFavorite($favorite)
    {

    }

    function changePassword($oldPassword, $newPassword)
    {

    }

    function changeEmail($newEmail)
    {

    }

    function deleteAccount()
    {

    }

    function resetPassword()
    {

    }
}
