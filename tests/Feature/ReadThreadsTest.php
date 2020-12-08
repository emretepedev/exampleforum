<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = Thread::factory()->create();

        $this->get('/threads')
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = Thread::factory()->create();

        $this->get($thread->path())
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associate_with_a_thread()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function it_has_an_owner()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(User::class, $thread->creator);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = User::factory()->create());
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $thread = Thread::factory()->create();

        $thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);
        $this->assertCount(1, $thread->replies);
    }
}
