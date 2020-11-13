<?php

class User
{

    function __construct($name, $email, $username, $password, $favorites)
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->favorites = $favorites;
        $this->qdb = new QueryDB();
    }

    function verifyLogin($enteredPassword)
    {
        $row = $this->qdb->fetchRow("SELECT * FROM USERS WHERE username='$this->name'");
        $storedPassword = $row[password];
        $enteredPasswordHash = password_hash($enteredPassword, PASSWORD_DEFAULT);

        return ($enteredPasswordHash == $storedPassword);
    }

    function addFavorite($location_id)
    {
        $query = "INSERT INTO USERS_FAVORITES (username, location_id) VALUES ('$this->name', $location_id)";
        return $this->qdb->executeSQL($query);
    }

    function removeFavorite($location_id)
    {
        $query = "DELETE FROM USERS_FAVORITES WHERE username='$this->name' AND location_id=$location_id";
        return $this->qdb->executeSQL($query);
    }

    function changePassword($oldPassword, $newPassword)
    {
// check password
        if ($this->verifyLogin($oldPassword)) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE USERS SET password='$newPasswordHash' WHERE username='$this->name'";
            return $this->qdb->executeSQL($query);
        } else {
// incorrect password
            return false;
        }
    }

    function changeEmail($newEmail)
    {
        $query = "UPDATE USERS SET email='$newEmail' WHERE username='$this->name'";
        return $this->qdb->executeSQL($query);
    }

    function deleteAccount()
    {
        $query = "DELETE FROM USERS WHERE username='$this->name'";
        return $this->qdb->executeSQL($query);
    }
}
