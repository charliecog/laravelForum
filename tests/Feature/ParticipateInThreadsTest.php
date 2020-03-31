<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->post('/threads/bob/1/replies', [])
             ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        //given we have an authenticated user
        //sets user as logged in
        $this->signIn();

        //and an existing thread
        $thread = create('App\Thread');

        //when the user adds a reply to the thread
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        //then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);

    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }
}
