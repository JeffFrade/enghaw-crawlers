<?php

namespace App\Core\Console\Commands;

use App\Core\Services\CrawlerService;
use Illuminate\Console\Command;

class CrawlerStartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:start {crawler}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $crawler = strtoupper($this->argument('crawler'));
        if (app(CrawlerService::class)->exec($crawler) === true) {
            $this->info('Crawler ' . $crawler .  ' Executed!');
            return true;
        }

        $this->error('Error Running Crawler ' . $crawler);
        return false;
    }
}
