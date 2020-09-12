<?php

namespace App\Core\Services;

class CrawlerService
{
    /**
     * @var array
     */
    private $crawlers = [
        'VAGALUME' => \App\Crawlers\Vagalume::class
    ];

    /**
     * @param string $crawler
     * @return bool
     */
    public function exec(string $crawler)
    {
        return app($this->crawlers[$crawler])->run();
    }
}
