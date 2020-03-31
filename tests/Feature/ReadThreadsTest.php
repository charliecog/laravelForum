<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_see_all_threads()
    {

        $this->get('/threads')
             ->assertSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {

        $this->get($this->thread->path())
             ->assertSee($this->thread->title);

    }
    
    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
             ->assertSee($reply->body);
    }
    
    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        //a user
        $this->signIn(create('App\User', ['name'=>'JohnDoe']));
        //a thread
        $threadByJohn = create('App\Thread',['user_id'=>\auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        //get a url
        //see those threads
        $this->get("/threads?by=JohnDoe")
             ->assertSee($threadByJohn->title)
             ->assertDontSee($threadNotByJohn->title);;
    }
}
