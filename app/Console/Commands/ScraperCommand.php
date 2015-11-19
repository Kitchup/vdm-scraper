<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Underscore\Types\Arrays;
use App\Vdm\Scraper;
use App\Repositories\PostRepository;
use App\Post;

class ScraperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vdm:scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the last 200 entries from http://www.viedemerde.fr and saves them in the database';

    /**
     * The Post repository
     *
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * The Scraper
     *
     * @var Scraper
     */   
    protected $scraper;


    /**
     * Create a new command instance.
     *
     * @return ScraperCommand
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->scraper = new Scraper();
        $this->postRepository = new PostRepository(new Post());

        $this->info("Fetching posts from vdm...");

        $posts = $this->scraper->scrap(200);

        $this->info(sprintf("Saving %d posts.", Arrays::size($posts)));

        Arrays::each($posts, function($post) { $this->postRepository->create($post->toArray()); }); 

        $this->info("Done.");
    }
}
