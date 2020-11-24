<?php
include_once 'Location.php';
include_once 'WeatherAPI.php';
include_once 'WeatherIcons.php';

class WeatherManager
{
    private $weatherHTML;
    private $locationDetails;
    private $user;

    public function __construct()
    {
        $this->weatherHTML = new Weather();
        $this->locationDetails = new Location();
        $this->user = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
    }

    /**
     * @param $data
     * @return string
     * returns the complete weather banner along with the temp based on the API data
     */
    private function weatherDetails($data)
    {
        $timezone = $data["timezone_offset"];
        $currentTemp = (int)floor($data["current"]["temp"]);
        $currentTempID = (int)$data["current"]["weather"][0]["id"];

        $laterTemp = (int)floor($data["hourly"][5]["temp"]);
        $laterTempID = (int)$data["hourly"][5]["weather"][0]["id"];

        $futureTemp = (int)floor($data["daily"][1]["temp"]["day"]);
        $futureTempID = (int)$data["daily"][1]["weather"][0]["id"];

        $weather = '<div class="weather">';
        $weather .= "<div class='weather-a'>";
        $weather .= '<div class="location-weather"><h3>Today</h3>';
        $weather .= $this->weatherDetailsIcon($currentTempID, $timezone) . '<p class="location-temp">' . $currentTemp . '°F</p></div>';
        $weather .= '<div class="location-weather"><h3>Later</h3>';
        $weather .= $this->weatherDetailsIcon($laterTempID, $timezone) . '<p class="location-temp">' . $laterTemp . '°F</p></div>';
        $weather .= '<div class="location-weather"><h3>Tomorrow</h3>';
        $weather .= $this->weatherDetailsIcon($futureTempID, $timezone) . '<p class="location-temp">' . $futureTemp . '°F</p></div>';
        $weather .= "</div>";

        $weather .= "<div class='weather-a'>";
        $weather .= '<div class="location-weather"><h3>Current</h3>';
        $weather .= '<p class="location-temp">' . $data["current"]["weather"][0]["description"] . '</p></div>';

        $weather .= '<div class="location-weather"><h3>Real Temp</h3>';
        $weather .= '<p class="location-temp">' . floor($data["current"]["feels_like"]) . '°F</p></div>';

        $weather .= '<div class="location-weather"><h3>Humidity</h3>';
        $weather .= '<p class="location-temp">' . floor($data["current"]["humidity"]) . '%</p></div>';

        $weather .= '<div class="location-weather"><h3>Wind</h3>';
        $weather .= '<p class="location-temp">' . floor($data["current"]["wind_speed"]) . ' MPH</p></div>';
        $weather .= "</div>";
        return $weather;
    }

    /**
     * @param $weatherID
     * @param $timezone
     * @return string
     * returns the correct weather icon based on a set of codes from the API
     *
     */
    private function weatherDetailsIcon($weatherID, $timezone)
    {
        $utcTime = date("H", strtotime((time() - (float)$timezone) . ' UTC'));
        $storm = array(200, 201, 202, 210, 211, 212, 221, 230, 231, 232);
        $rain = array(300, 301, 302, 310, 311, 312, 313, 314, 321, 500, 501, 502, 503, 504, 511, 520, 521, 522, 531);
        $snow = array(600, 601, 602, 611, 612, 613, 615, 616, 620, 621, 622);
        $clear = array(800);
        $partialClouds = array(801, 802);
        $clouds = array(803, 804);

        $weatherID = (int)$weatherID;
        $weather = "";
        in_array($weatherID, $storm) ? $weather = $this->weatherHTML->storm() : null;
        in_array($weatherID, $rain) ? $weather = $this->weatherHTML->rainy() : null;
        in_array($weatherID, $snow) ? $weather = $this->weatherHTML->snow() : null;
        if (in_array($weatherID, $clear)) {
            if ($utcTime < "19") {
                $weather = $this->weatherHTML->sunny();
            } else {
                $weather = $this->weatherHTML->clearNight();
            }
        } else if (in_array($weatherID, $partialClouds)) {
            if ($utcTime < "19") {
                $weather = $this->weatherHTML->cloudyWithSun();
            } else {
                $weather = $this->weatherHTML->clearNight();
            }
        } else if (in_array($weatherID, $clouds)) {
            if ($utcTime < "19") {
                $weather = $this->weatherHTML->cloudy();
            } else {
                $weather = $this->weatherHTML->cloudWithMoon();
            }
        }
        return $weather;
    }

    /**
     * @param $isFavorite
     * @param $data
     * @return string
     * Returns the location banner in its complete form
     * Shows location information along with the weather details
     */
    private function locationBanner($isFavorite, $data)
    {
        $htmlStart = '<section class="content-a">';

        $innerHTML = '<div class="location" id="' . $this->locationDetails->getUid() . '">';
        $innerHTML .= '<div class="location-tools" id="loc-' . $this->locationDetails->getUid() . '">';
        if ($_SESSION["logged"]) {
            $innerHTML .= '<input class="favorite" type="checkbox" name="chk' . $this->locationDetails->getUid() . '" id="chk' . $this->locationDetails->getUid() . '" onchange="favorites(this)">';
            if ($isFavorite) {
                $innerHTML .= '<label class="favorite-label" for="chk' . $this->locationDetails->getUid() . '" title="unfavorite"><img src="./content/like.svg"  alt="is favorite"/></label>';
            } else {
                $innerHTML .= '<label class="favorite-label" for="chk' . $this->locationDetails->getUid() . '" title="favorite"><img src="./content/notlike.png"  alt="not favorite"/></label>';
            }
        }
        $innerHTML .= "<button type='button' class='map' onclick='displayMap(this.name);return false;' name='" . $this->locationDetails->getUid() . "' title='Show/Hide Map'><img src='./content/map.svg' alt='show/hide map'></button>";
        $innerHTML .= "</div>";
        $innerHTML .= '<p class="location-details">Region: ' . $this->locationDetails->getCityName() .
            ($this->locationDetails->getStateName() === null || $this->locationDetails->getStateName() === "" ? null : ', ' . $this->locationDetails->getStateName()) . '</p>';
        $innerHTML .= '<p class="location-details">Country: ' . $this->locationDetails->getCountryName() . '</p>';
        $innerHTML .= '</div>';

        $weather = $this->weatherDetails($data);

        $htmlEnd = '</section>';

        return $htmlStart . $innerHTML . $weather . $htmlEnd;
    }

    /**
     * @param $lat
     * @param $lon
     * @param $zoom
     * @return string
     * returns the map based on the inputted location details
     *
     */
    public function map($lat, $lon, $zoom, $uid)
    {
        $embed = "https://embed.windy.com/embed2.html?lat={$lat}&lon={$lon}&detailLat={$lat}&detailLon={$lon}&width=650&height=450&zoom={$zoom}&level=surface&overlay=wind&product=ecmwf&menu=&message=&marker=&calendar=now&pressure=&type=map&location=coordinates&detail=&metricWind=default&metricTemp=default&radarRange=-1";
        $sectionStart = '<section class="content-b" id="map-' . $uid . '" style="display:none">';
        $iframe = '<iframe width="100%" height="100%" src="' . $embed . '"frameborder="0"></iframe>';
        $sectionEnd = '</section>';
        return $sectionStart . $iframe . $sectionEnd;
    }

    /**
     * @param $lat
     * @param $lon
     * @return array
     * Returns the weather API data in JSON form
     */
    private function showWeather($lat, $lon)
    {
        $weatherData = new WeatherAPI($lat, $lon);
        return $weatherData->processRequest();
    }


    /**
     * @return string
     * Displays the user's personal favorites based on the active user
     */
    public function showFavorites()
    {
        $html = "";
        $favorites = $this->locationDetails->userFavorites($this->user);
        if (count($favorites) > 0) {
            for ($i = 0; $i < count($favorites); $i++) {
                $this->locationDetails->setUid((float)$favorites[$i][0]);
                if ($this->locationDetails->getLocationDetails()) {
                    $jsonData = $this->showWeather(
                        $this->locationDetails->getLatitude(),
                        $this->locationDetails->getLongitude());

                    $html .= "<div class='t'>";
                    $html .= $this->locationBanner(true, $jsonData);

                    $html .= $this->map($this->locationDetails->getLatitude(), $this->locationDetails->getLongitude(), 8, $this->locationDetails->getUid());
                    $html .= "</div>";
                } else {
                    $html .= "<div class='t'>";
                    $html .= "</div>";
                }
            }
        } else {
            $html = $this->showRandom(1);
        }
        return $html;
    }

    public function showResults($string)
    {
        $html = "";
        $searchResults = $this->locationDetails->search($string);

        if (count($searchResults) > 0) {
            for ($i = 0; $i < count($searchResults); $i++) {
                $this->locationDetails->setUid((float)$searchResults[$i][0]);
                if ($this->locationDetails->getLocationDetails()) {
                    $jsonData = $this->showWeather(
                        $this->locationDetails->getLatitude(),
                        $this->locationDetails->getLongitude());

                    $html .= "<div class='t'>";
                    $html .= $this->locationBanner(false, $jsonData);

                    $html .= $this->map($this->locationDetails->getLatitude(), $this->locationDetails->getLongitude(), 8, $this->locationDetails->getUid());
                    $html .= "</div>";
                } else {
                    $html .= "<div class='t'>";
                    $html .= "</div>";
                }
            }
        } else {
            $html = "No Results Found";
        }
        return $html;

    }

    /**
     * @param $cnt
     * @return string
     * shows a random location repeat based on the number of times set
     */
    function showRandom($cnt)
    {
        $html = "";
        for ($i = 0; $i < $cnt; $i++) {
            if ($this->locationDetails->explore()) {
                $jsonData = $this->showWeather(
                    $this->locationDetails->getLatitude(),
                    $this->locationDetails->getLongitude());

                $html .= "<div class='t'>";
                $html .= $this->locationBanner(false, $jsonData);
                $html .= $this->map($this->locationDetails->getLatitude(), $this->locationDetails->getLongitude(), 8, $this->locationDetails->getUid());
                $html .= "</div>";
            } else {
                $html .= "<div class='t'>";
                $html .= "</div>";
            }
        }
        return $html;
    }
}
