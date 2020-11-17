<?php
include_once 'QueryDB.php';

class WeatherAPI
{
    private $apiKey;
    //private string $currentURL = "api.openweathermap.org/data/2.5/group?id={id}&units=imperial&appid={key}";
    private $currentURL = "api.openweathermap.org/data/2.5/onecall?lat={lat}&lon={lon}&exclude=minutely&units=imperial&appid={key}";
    private $key;
    private $lat;
    private $lon;

    public function __construct($lat, $lon)
    {
        $this->apiKey = new QueryDB();
        $this->key = $this->apiKey->getApiKey();
        $this->lat = (float)$lat;
        $this->lon = (float)$lon;
    }

    private function prepareBasicURL()
    {
        if ($this->lat === null || $this->lon === null || $this->key === null) {
            return false;
        }
        $this->currentURL = str_replace("{lat}", $this->lat, $this->currentURL);
        $this->currentURL = str_replace("{lon}", $this->lon, $this->currentURL);
        $this->currentURL = str_replace("{key}", $this->key, $this->currentURL);
        return true;
    }

    private function getWeatherData()
    {
        if ($this->prepareBasicURL()) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->currentURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"),));
            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            return $response;
        } else {
            return "";
        }
    }

    public function processRequest()
    {
        $rawData = $this->getWeatherData();
        if ($rawData === "") {
            return [];
        } else {
            return json_decode($rawData, true);
        }
    }

}
