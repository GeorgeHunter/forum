<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_an_unauthenticated_user_cannot_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);

    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());
//        $user = factory('App\User')->create();
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();
        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

        $this->get('/threads/' . $thread->id )
            ->assertSee($reply->body);
    }
}
