<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    public function create(array $attributes)
    {
        $createPost = DB::transaction(function () use ($attributes) {
            $createPost = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitle'),
                'body' =>  data_get($attributes, 'body'),
            ]);
            if ($userIds =  data_get($attributes, 'user_ids')) {
                $createPost->users()->sync($userIds);
            }
            return $createPost;
        });
    }

    public function update()
    {
    }

    public function forceDelete()
    {
    }
}
