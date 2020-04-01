<?php

namespace Tests\Feature;

use App\Favourite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_favourite_anything()
    {

        //if i post to a "favourite" endpoint
        $this->post('replies/1/favourites')
            ->assertRedirect('/login');


    }

    /** @test */
    public function an_authenticated_user_can_favourite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        //if i post to a "favourite" endpoint
        $this->post('replies/' . $reply->id . '/favourites');

        //it should be recorded in the database
        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_authenticated_may_only_favourite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        //if i post to a "favourite" endpoint twice
        $this->post('replies/' . $reply->id . '/favourites');
        $this->post('replies/' . $reply->id . '/favourites');

        //it should be recorded in the database
        $this->assertCount(1, $reply->favourites);
    }
}
