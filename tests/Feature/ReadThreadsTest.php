<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test **/
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_view_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_see_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);
        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);

    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    
    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn =  create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
    
    public function test_a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
