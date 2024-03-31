<?php

namespace App\Console\Commands;

use App\Liste;
use App\Journal;
use App\User;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Database\Eloquent\Builder;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('status', 0)->get();

        $lists = Liste::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->get();

        $journals = Journal::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->get();

        // modify this to your own needs
        $sitemap = SitemapGenerator::create(env('APP_URL'))
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->ignoreRobots();
            })
            ->hasCrawled(function (Url $url) {

                if ($url->segment(1) === 'user') {
                    return;
                }

                if ($url->segment(1) === 'list') {
                    return;
                }

                if ($url->segment(1) === 'journal') {
                    return;
                }

                if ($url->segment(1) === 'password') {
                    return;
                }

                if ($url->segment(1) === 'user_lists') {
                    return;
                }

                if ($url->segment(1) === 'user_journals') {
                    return;
                }

                return $url;
            });

        foreach ($users as $user) {
            $sitemap->getSitemap()->add(Url::create("/user/" . $user->slug)->setPriority(0.8));
        }
        foreach ($lists as $list) {
            $sitemap->getSitemap()->add(Url::create("/list/" . $list->slug)->setPriority(0.8));
        }
        foreach ($journals as $journal) {
            $sitemap->getSitemap()->add(Url::create("/journal/" . $journal->slug)->setPriority(0.8));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
