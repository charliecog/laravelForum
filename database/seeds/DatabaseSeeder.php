<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $channels;
    protected $users;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

//        $this->channels = factory('App\Channel', 10)->create();
//
//        $this->users = factory('App\User', 50)->create();

//        $this->users->each(function($user) {
//            $randomChannelId = $this->channels[array_rand(range(1,10))];
//            $randomUserId = $this->users[array_rand(range(1, 50))];
//            $threads = factory('App\Thread', rand(1,10))->create(['channel_id' => $randomChannelId, 'user_id' => $randomUserId]);
//            $threads->each(function($thread) {
//                $randomUserId = $this->users[array_rand(range(1, 50))];
//                factory('App\Reply', rand(1,7))->create(['thread_id' => $thread->id,'user_id' => $randomUserId]);
//            });
//        });

        $threads = factory('App\Thread', 50)->create();
        $threads->each(function($thread) {
            factory('App\Reply', rand(1,7))->create(['thread_id' => $thread->id]);
        });

    }
}
