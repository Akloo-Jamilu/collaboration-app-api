<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(PostRepository::class);

        $payLoad = [
            'title' => 'Coming home',
            'body' => []
        ];

        $result = $repository->create($payLoad);

        $this->assertSame($payLoad['title'], $result->title, 'Post create does not have the same title.');
    }

    public function test_update()
    {
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        $payLoad = [
            'title' => 'hay jamilu'
        ];

        $result = $repository->update($dummyPost, $payLoad);

        $this->assertSame($payLoad['title'], $result->title, 'Post create does not have the same title.');
    }

    public function test_delete_will_throw_exception_when_delete_post_post_that_doesnt_exixt()
    {
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->make()->first();


        $repository->forceDelete($dummy);
    }

    public function test_delete()
    {
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->create()->first();

        $result = $repository->forceDelete($dummy);

        $found = Post::query()->find($dummy->id);

        $this->assertSame(null, $found, 'Post is deleted');
    }
}
