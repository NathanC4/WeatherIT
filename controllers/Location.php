<?php
include_once 'QueryDB.php';

class Location
{
    private float $latitude;
    private float $longitude;
    private int $zoom;
    private string $cityName;
    private string $countryName;
    private string $stateName;
    private float $uid;
    private float $favoriteUID;

    private QueryDB $db;

    function __construct()
    {
        $this->db = new QueryDB();
    }

    /**
     * @param $activeUser
     * @return array
     */
    function userFavorites($activeUser): array
    {
        return $this->db->fetchRows("SELECT location_id FROM USERS_FAVORITES WHERE username='$activeUser'");
    }

    function getLocationDetails(): bool
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

    function explore(): bool
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
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @param int $zoom
     */
    public function setZoom(int $zoom): void
    {
        $this->zoom = $zoom;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    /**
     * @param string $stateName
     */
    public function setStateName(string $stateName): void
    {
        $this->stateName = $stateName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }

    /**
     * @param float $uid
     */
    public function setUid(float $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @return string
     */
    public function getStateName(): string
    {
        return $this->stateName;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @return double
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return double
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getZoom(): int
    {
        return $this->zoom;
    }

    /**
     * @return float
     */
    public function getUid(): float
    {
        return $this->uid;
    }

}
