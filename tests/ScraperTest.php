<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Vdm\Scraper;
use Underscore\Types\Arrays;

class ScraperTest extends TestCase
{
    /** @test
     */
    public function itRetrievesPosts()
    {
    	$scraper = new Scraper();
    	$posts = $scraper->setBaseUrl(base_path()."/tests/test.html")->scrap(1);


    	$this->assertEquals(1, Arrays::size($posts));
    	$this->assertEquals('apaogi', $posts[0]->author);
    	$this->assertEquals('2015-11-18 12:56:00', $posts[0]->date);
    	$this->assertEquals(8643413, $posts[0]->vdm_id);
    }

    /** @test
     */
    public function itRetrievesGoodAmountOfPosts()
    {
    	$scraper = new Scraper();
    	$posts = $scraper->setBaseUrl(base_path()."/tests/test.html")->scrap(10);


    	$this->assertEquals(10, Arrays::size($posts));
    }
}
