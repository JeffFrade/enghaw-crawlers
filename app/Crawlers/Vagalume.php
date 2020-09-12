<?php

namespace App\Crawlers;

use App\Core\Helpers\FileHelper;
use App\Core\Helpers\StringHelper;
use App\Core\Interfaces\CrawlerInterface;
use App\Core\Support\CrawlerUtil;

class Vagalume extends CrawlerUtil implements CrawlerInterface
{
    /**
     * @var string
     */
    private $baseUrl = 'https://www.vagalume.com.br';

    /**
     * @var array
     */
    private $search = [
        'engenheiros-do-hawaii',
        'pouca-vogal',
        'humberto-gessinger'
    ];

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run()
    {
        $this->setIniVariables();

        foreach ($this->search as $search) {
            $this->getMusicsPage($search);
        }

        return true;
    }

    /**
     * @param string $search
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return void
     */
    private function getMusicsPage(string $search)
    {
        $url = $this->baseUrl . '/' . $search;

        $page = $this->getGuzzle()
            ->request('GET', $url)
            ->getBody()
            ->getContents();

        $page = StringHelper::clearPageContent($page);

        $list = $this->getMusicsList($page);
        $urls = $this->getMusicsUrls($list);

        $this->getMusics($urls);
    }

    /**
     * @param string $page
     * @return string
     */
    private function getMusicsList(string $page)
    {
        $list = StringHelper::doRegex($page, '/<ol id=alfabetMusicList>[\w\W]+?<\/ol>/i');

        return $list[0][0] ?? '';
    }

    /**
     * @param string $list
     * @return array
     */
    private function getMusicsUrls(string $list)
    {
        $urls = StringHelper::doRegex($list, '/href=([\w\W]+?)(\s|\#)/');

        return array_unique($urls[1]);
    }

    /**
     * @param array $urls
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return void
     */
    private function getMusics(array $urls)
    {
        foreach ($urls as $url) {
            $url = $this->baseUrl . $url;

            $this->accessMusicPage($url);
        }
    }

    /**
     * @param string $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return void
     */
    private function accessMusicPage(string $url)
    {
        $page = $this->getGuzzle()
            ->request('GET', $url)
            ->getBody()
            ->getContents();

        $page = StringHelper::clearPageContent($page);

        $this->getData($page);
    }

    /**
     * @param string $page
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return void
     */
    private function getData(string $page)
    {
        $musicTitle = $this->getMusicTitle($page);
        $musicContent = $this->getMusicContent($page);

        if (!empty($musicTitle) || !empty($musicContent)) {
            $data = [
                'title' => $musicTitle,
                'music' => $musicContent
            ];

            $this->sendToEngHawApi($data);
        }
    }

    /**
     * @param string $page
     * @return string
     */
    private function getMusicTitle(string $page)
    {
        $musicTitle = StringHelper::doRegex($page, '/<h1>([\w\W]+?)<\/h1>/i');
        $musicTitle = StringHelper::replaceRegex($musicTitle[1][0] ?? '', '/<br[\W]*?>/i', ' ');
        $musicTitle = strip_tags($musicTitle);
        $musicTitle = StringHelper::removeAccents($musicTitle);

        return strtoupper($musicTitle);
    }

    /**
     * @param string $page
     * @return string
     */
    private function getMusicContent(string $page)
    {
        $musicContent = StringHelper::doRegex($page, '/<div id=lyrics[\w\W]+?>([\w\W]+?)<\/div>/i');
        $musicContent = StringHelper::replaceRegex($musicContent[1][0] ?? '', '/<br[\W]*?>/i', ' ');
        $musicContent = strip_tags($musicContent);
        $musicContent = StringHelper::removeAccents($musicContent);

        return strtoupper($musicContent);
    }

    /**
     * @param array $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendToEngHawApi(array $data)
    {
        $this->getEngHawApi()->storeMusic($data);
    }
}
