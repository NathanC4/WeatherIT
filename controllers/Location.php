<?php

use JetBrains\PhpStorm\Pure;

include_once 'QueryDB.php';
include_once 'Weather.php';

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

    private Weather $weatherHTML;
    private QueryDB $db;

    function __construct()
    {
        $this->db = new QueryDB();
        $this->weatherHTML = new Weather();
    }

    /**
     * @param $content
     * @return string
     */
    public function locationText($content): string
    {
        $htmlStart = '<section class="content-a">';

        if ($content === null) {
            $innerHTML = '<div class="location" id="' . $this->getUid() . '">';
            $innerHTML .= '<input class="favorite" type="checkbox" name="favorite" id="favorite">';
            $innerHTML .= '<label class="favorite-label" for="favorite"><img src="./content/like.png" /></label>';
            $innerHTML .= '<p class="location-details">Region: ' . $this->getCityName() .
                ($this->getStateName() === null || $this->getStateName() === "" ? null : ', ' . $this->getStateName()) . '</p>';
            $innerHTML .= '<p class="location-details">Country: ' . $this->getCountryName() . '</p>';
            $innerHTML .= '</div>';
        } else {
            $innerHTML = 'in progress';
        }
        $weather = '<div class="weather">';
        $weather .= '<div class="location-weather"><h3>Today</h3>';
        $weather .= $this->weatherHTML->cloudy() . '<p class="location-temp">60°F</p></div>';
        $weather .= '<div class="location-weather"><h3>Tonight</h3>';
        $weather .= $this->weatherHTML->sunnyWithWind() . '<p class="location-temp">45°F</p></div>';
        $weather .= '<div class="location-weather"><h3>Tomorrow</h3>';
        $weather .= $this->weatherHTML->snow() . '<p class="location-temp">34°F</p></div>';
        $weather .= '</div>';

        $htmlEnd = '</section>';

        return $htmlStart . $innerHTML . $weather . $htmlEnd;
    }

    function getLocationDetails($activeUser): bool
    {
        try {
            $SQLa = "SELECT * FROM USERS_FAVORITES WHERE username='$activeUser'";
            $query = $this->db->fetchRow($SQLa);
            if (count($query) > 0) {
                $locationID = $query["location_id"];
                $SQLb = "SELECT * FROM LOCATIONS_DATA WHERE location_id='$locationID'";
                $queryResults = $this->db->fetchRow($SQLb);

                if (count($queryResults) > 0) {

                    $this->setLatitude($queryResults["coord_lat"]);
                    $this->setLongitude($queryResults["coord_lon"]);
                    $this->setZoom(6);
                    $this->setCityName($queryResults["city"]);
                    $this->setStateName($queryResults["state"]);
                    $this->setCountryName($queryResults["country"]);
                    $this->setUid($queryResults["location_id"]);
                    return true;
                }
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
        $this->db->closeConnection();
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
