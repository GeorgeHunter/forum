<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavouritesTest extends TestCase
{

    use DatabaseMigrations;

    public function test_a_guest_cannot_favourite_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favourite')
            ->assertRedirect('/login');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_favourite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post("replies/$reply->id/favourite");

        $this->assertCount(1, $reply->favourites);
    }

    public function test_an_authenticated_user_may_only_favourite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post("replies/$reply->id/favourite");
            $this->post("replies/$reply->id/favourite");
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record twice');
        }

        $this->assertCount(1, $reply->favourites);
    }
}
