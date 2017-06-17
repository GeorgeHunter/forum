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
        $this->withExceptionHandling()
            ->post('threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
//        $this->expectException('Illuminate\Auth\AuthenticationException');
//
//        $this->post('/threads/some-channel/1/replies', []);

    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create('App\User'));
//        $user = factory('App\User')->create();
        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path() )
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_body_is_required()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    public function test_unauthorised_users_cannot_delete_a_reply ()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function test_authorised_users_can_delete_a_reply ()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_authorised_users_can_update_replies ()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'Updated content';

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }



    public function test_unauthorised_users_cannot_update_a_reply ()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $updatedReply = 'Updated content';

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply])
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}", ['body' => $updatedReply])
            ->assertStatus(403);
    }

}
