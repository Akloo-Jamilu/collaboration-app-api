<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $createUser = User::query()->create([
                'name' => data_get($attributes, 'name'),
                'email' =>  data_get($attributes, 'email'),
            ]);

            throw_if(!$createUser, GeneralJsonException::class, 'Failed to create user.');

            if ($userIds =  data_get($attributes, 'user_ids')) {
                $createPost->users()->sync($userIds);
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

            throw_if(!$updatePost, GeneralJsonException::class, 'Failed to update post.');

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

            throw_if(!$deletePost, GeneralJsonException::class, 'Failed to delete post.');

            return $deletePost;
        });
    }
}
