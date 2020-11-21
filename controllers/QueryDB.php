<?php

class QueryDB
{
    //handles all query operations
    /**
     * @var mysqli
     */
    private $msqli;
    private $apiKey = "649dc78ddc1f1fd88560838daa3e5f04";

    function __construct()
    {
        $this->msqli = new mysqli('localhost', 'root', '', 'weather_it');
        $this->apiKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param $query
     * @return mysqli_result|bool
     * Executes an update to the database and returns a bool value based on success or failure
     * Only for insert, update, or delete statements
     */
    function executeSQL($query)
    {
        try {
            return $this->msqli->query($query);
        } catch (Exception $e) {
            print $e;
            return false;
        }
    }

    /**
     * @param $query
     * @return array
     * Returns a single row of data from SQL statement
     * SQL should use WHERE clause for specific row
     */
    function fetchRow($query)
    {
        try {
            $results = $this->msqli->query($query)->fetch_array();
            if ($results === null) {
                return [];
            } else {
                return $results;
            }
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $query
     * @return array
     * Returns a larger array of values based on what is in the table
     */
    function fetchRows($query)
    {
        try {
            $results = $this->msqli->query($query)->fetch_all();
            if ($results === null) {
                return [];
            } else {
                return $results;
            }
        } catch (Exception $exception) {
            return [];
        }
    }

    public function viewRegisteredUsers()
    { // < -- table and view -->
    }

    /**
     * @param $query
     * @return array
     * Returns a list of the table column names from the database based on the query
     */
    function fetchColumnNames($query)
    {
        return $this->msqli->query($query)->fetch_fields();
    }

    /**
     *Closes the connection to the DB
     */
    function closeConnection()
    {
        $this->msqli->close();
    }

}
