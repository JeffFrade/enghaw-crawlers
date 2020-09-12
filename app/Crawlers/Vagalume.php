<?php

namespace App\Crawlers;

use App\Core\Interfaces\CrawlerInterface;
use App\Core\Support\CrawlerUtil;

class Vagalume extends CrawlerUtil implements CrawlerInterface
{
    public function run()
    {
        $this->setIniVariables();

        dump("Ola");

        return true;
    }
}
