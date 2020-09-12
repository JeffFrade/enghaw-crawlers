<?php

namespace App\Core\Support;

use App\Core\Helpers\FileHelper;
use App\Core\Services\EngHawApi;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

abstract class CrawlerUtil
{
    /**
     * @var EngHawApi
     */
    private $engHawApi;

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var string
     */
    private $cookie;

    /**
     * @return void
     */
    protected function setIniVariables()
    {
        set_time_limit(0);
        ini_set('memory_limit', '8G');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("pcre.recursion_limit", "100000000");
    }

    /**
     * @param EngHawApi $engHawApi
     */
    public function setEngHawApi(EngHawApi $engHawApi)
    {
        $this->engHawApi = $engHawApi;
    }

    /**
     * @return EngHawApi
     */
    public function getEngHawApi()
    {
        return $this->engHawApi ?? $this->createDefaultEngHawApi();
    }

    /**
     * @return EngHawApi
     */
    private function createDefaultEngHawApi()
    {
        return new EngHawApi();
    }

    /**
     * @param Client $client
     */
    public function setGuzzle(Client $client)
    {
        $this->guzzle = $client;
    }

    /**
     * @return Client
     */
    public function getGuzzle()
    {
        return $this->guzzle ?? $this->createDefaultGuzzle();
    }

    /**
     * @return Client
     */
    private function createDefaultGuzzle()
    {
        $cookie = new FileCookieJar($this->getCookie(), true);

        return new Client([
            'cookies' => $cookie,
            'connect_timeout' => 0,
            'timeout' => 0,
            'follow_location' => true,
            'binary_transfer' => true,
        ]);
    }

    /**
     * @param string $cookie
     */
    private function setCookie(string $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie ?? $this->createDefaultCookie();
    }

    /**
     * @return string
     */
    private function createDefaultCookie()
    {
        $filename = 'cookies/' . rand() . '_cookie.txt';
        FileHelper::writeArchive('', $filename);
        return base_path() . '/storage/app/public/' . $filename;
    }
}
