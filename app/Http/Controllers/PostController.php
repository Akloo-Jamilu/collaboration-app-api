<?php

namespace App\Http\Controllers;

use App\Models\Post;

use \Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $posts = Post::query()->paginate(20);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, PostRepository $repository)
    {
        $createPost = $repository->create($request->only([
            'tittle',
            'body',
            'user_ids'
        ]));
        return new PostResource($createPost);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return ResourceCollection
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return ResourceCollection
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // $post->update($request->only(['tittle', 'body']));
        $updatePost = $post->update([
            'tittle' => $request->tittle ?? $post->tittle,
            'body' => $request->body ?? $post->body,
        ]);
        if (!$updatePost) {
            return new JsonResponse([
                'error' => [
                    'Failed to update post'
                ]
            ], 400);
        }
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return ResourceCollection
     */
    public function destroy(Post $post)
    {
        $deletePost = $post->forceDelete();
        if (!$deletePost) {
            return new JsonResponse([
                'error' => [
                    'Failed to delete post'
                ]
            ], 400);
        }
        return new JsonResponse([
            'data' => 'success'
        ]);
    }
}
