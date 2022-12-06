<?php

namespace App\Http\Controllers;

use App\Models\Post;

use \Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()->get();

        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $createPost = Post::query()->create([
            'tittle' => $request->tittle,
            'body' => $request->body,
        ]);

        return new JsonResponse([
            'data' => $createPost
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
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
        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
