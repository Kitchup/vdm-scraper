<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VdmControllerTest extends TestCase
{
    /**
     * @test
     */
    public function itFetchesPosts()
    {
        json_decode($this->call('GET','api/posts')->getContent());
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function itDoesntFetchFromRandomUri()
    {
        json_decode($this->call('GET','api/postss')->getContent());
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function itFetchesPostById()
    {
        $post=json_decode($this->call('GET','api/posts/2')->getContent())->post;
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function itNotifiesWhenNotFound()
    {
        $post=json_decode($this->call('GET','api/posts/985')->getContent());
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function itFetchesPostWithProperAttributes()
    {
        $post=json_decode($this->call('GET','api/posts/2')->getContent())->post;
        $this->assertResponseOk();

        $attributes = ['content', 'date', 'author'];
        foreach ($attributes as $attribute)
        {
        	 $this->assertObjectHasAttribute($attribute, $post);
        }
    }
}
