<?php
include_once 'QueryDB.php';

class Location
{
    private $latitude;
    private $longitude;
    private $zoom;
    private $cityName;
    private $countryName;
    private $stateName;
    private $uid;

    private $db;

    function __construct()
    {
        $this->db = new QueryDB();
    }

    /**
     * @param $activeUser
     * @return array
     */
    function userFavorites($activeUser)
    {
        return $this->db->fetchRows("SELECT location_id FROM USERS_FAVORITES WHERE username='$activeUser'");
    }


    /**
     * @param $searchText
     * @return array
     */
    function search($searchText)
    {
        return $this->db->fetchRows("SELECT * FROM LOCATIONS_DATA WHERE city LIKE '%" . $searchText . "%' OR state LIKE '%" . $searchText . "%' OR country LIKE '%" . $searchText . "%' LIMIT 10");
    }

    function getLocationDetails()
    {
        try {
            $SQLb = "SELECT * FROM LOCATIONS_DATA WHERE location_id='$this->uid'";
            $queryResults = $this->db->fetchRow($SQLb);
            if (count($queryResults) > 0) {
                $this->setLatitude($queryResults["coord_lat"]);
                $this->setLongitude($queryResults["coord_lon"]);
                $this->setZoom(6);
                $this->setCityName($queryResults["city"]);
                $this->setStateName($queryResults["state"]);
                $this->setCountryName($queryResults["country"]);
                return true;
            }
        } catch (Exception $exception) {
            return false;
        }
        return false;
    }

    function explore()
    {
        $SQL = "SELECT * FROM LOCATIONS_DATA ORDER BY RAND() LIMIT 1";
        $random = $this->db->fetchRow($SQL);

        if (count($random) > 0) {
            $this->setLatitude($random["coord_lat"]);
            $this->setLongitude($random["coord_lon"]);
            $this->setZoom(6);
            $this->setCityName($random["city"]);
            $this->setStateName($random["state"]);
            $this->setCountryName($random["country"]);
            $this->setUid($random["location_id"]);
            return true;
        }
        return false;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @param int $zoom
     */
    public function setZoom(int $zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName)
    {
        $this->cityName = $cityName;
    }

    /**
     * @param string $stateName
     */
    public function setStateName(string $stateName)
    {
        $this->stateName = $stateName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName(string $countryName)
    {
        $this->countryName = $countryName;
    }

    /**
     * @param float $uid
     */
    public function setUid(float $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @return string
     */
    public function getStateName()
    {
        return $this->stateName;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * @return float
     */
    public function getUid()
    {
        return $this->uid;
    }

}
