<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_has_a_profile()
    {
        $user = create('App\User');
        $this->get("users/$user->name")
            ->assertSee($user->name);
    }

    public function test_a_users_profile_shows_all_their_threads()
    {
        $this->signIn();

         $thread = create('App\Thread', ['user_id' => auth()->id()]);

         $this->get("users/" . auth()->user()->name)
             ->assertSee($thread->title);
    }
}
