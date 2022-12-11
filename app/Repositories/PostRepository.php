<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $createPost = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitle'),
                'body' =>  data_get($attributes, 'body'),
            ]);
            if ($userIds =  data_get($attributes, 'user_ids')) {
                $createPost->users()->sync($userIds);
                // $createPost->users()->sync($userIds);
                // $createPost->users()->sync($userIds);
            }
            return $createPost;
        });
    }

    public function update($post, array $attributes)
    {
        return DB::transaction(function () use ($post, $attributes) {
            $updatePost = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' =>  data_get($attributes, 'body', $post->body),
            ]);

            if (!$updatePost) {
                throw new \Exception('failed post');
            }

            if ($userIds =  data_get($attributes, 'user_ids')) {
                $post->users()->sync($userIds);
            }

            return $post;
        });
    }
    public function forceDelete($post)
    {
        return DB::transaction(function () use ($post) {
            $deletePost = $post->forceDelete();

            if (!$deletePost) {
                throw new \Exception('failed to delete');
            }

            return $deletePost;
        });
    }
}
