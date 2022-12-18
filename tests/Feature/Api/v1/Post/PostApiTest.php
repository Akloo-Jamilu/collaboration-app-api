<?php

namespace Tests\Feature\Api\v1\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    public function test_index()
    {
        $Posts = Post::factory(19)->create();
        $postIds = $Posts->map(fn ($post)=> $post->id);
        $response = $this->json('get', '/api/v1/posts');

        $response->assertStatus(200);
        $data = $response->json('data');
        // collect($data)->each(fn($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));
        collect($data)->each(fn($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));
    }
}
