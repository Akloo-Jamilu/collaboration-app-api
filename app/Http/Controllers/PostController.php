<?php

namespace App\Http\Controllers;

use App\Models\Post;

use \Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
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
        // return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostRepository $repository)
    {
        $createPost = $repository->create($request->only([
            'title',
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return ResourceCollection
     */
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        // $post->update($request->only(['tittle', 'body']));

        $updatePost = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));
        return new PostResource($updatePost);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return ResourceCollection
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $deletePost = $repository->forceDelete($post);

        return new JsonResponse([
            'data' => 'success'
        ]);
    }
}
