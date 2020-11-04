<?php
include_once 'QueryDB.php';

class API_Controller
{
    private $time;
    private QueryDB $key;

    function __construct($time)
    {
        $this->time = $time;
        $this->key = new QueryDB();
    }

    private function processData(): array
    {
        $api = $this->key->getApiKey();
        return [];
    }

    private function insertData(): bool
    {
        return true;
    }

    public function confirmSuccess(): bool
    {

        return true;
    }

    public function isTime(): bool
    {

        if ($this->time) {
            try {
                $dataCollected = $this->processData();
                count($dataCollected) > 0 ? $insertSuccess = $this->insertData() : false;
                return $this->confirmSuccess();
            } catch (exception $e) {
                return false;
            }
        }
        return false;
    }
}



